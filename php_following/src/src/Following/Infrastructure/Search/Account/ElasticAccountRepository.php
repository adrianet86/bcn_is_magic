<?php


namespace App\Following\Infrastructure\Search\Account;


use App\Following\Domain\Model\Account\Account;
use App\Following\Domain\Model\Account\AccountExistsWithSameUsernameException;
use App\Following\Domain\Model\Account\AccountNotFoundException;
use App\Following\Domain\Model\Account\AccountRepository;
use Elastica\Client;
use Elastica\Document;
use Elastica\Index;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Exists;

class ElasticAccountRepository implements AccountRepository
{
    /** @var Client $client */
    private Client $client;
    /** @var Index $index */
    private Index $index;
    /** @var \Elastica\Type */
    private $type;

    public function __construct(Client $client, string $indexName)
    {
        $this->client = $client;
        $this->index = $this->client->getIndex($indexName);
        if (!$this->index->exists()) {
            $this->index->create([
                    "settings" => [
                        "number_of_shards" => 3,
                        "number_of_replicas" => 2,
//                        "blocks" => ["read_only_allow_delete" => false]
                    ],
                    "type" => "account"
                ]
            );
        }
        $this->type = $this->index->getType('account');
    }

    private function transformToDocument(Account $account): Document
    {
        return new Document(
            $account->id(),
            [
                'id' => $account->id(),
                'username' => $account->username(),
                'name' => $account->name(),
                'followers' => $account->followers(),
                'following' => $account->following(),
                'follower_ratio' => $account->followerRatio(),
                'created_at' => $account->createdAt()->format('Y-m-d H:i:s'),
                'instagram_id' => $account->instagramId(),
                'is_private' => $account->isPrivate(),
                'has_profile_picture' => $account->hasProfilePicture(),
                'is_business' => $account->isBusiness(),
                'biography' => $account->biography(),
                'media_count' => $account->mediaCount(),
                'from_account' => $account->fromAccount(),
                'from_method' => $account->fromMethod(),
                'follow_back' => $account->followBack(),
                'following_rating' => $account->followingRating(),
                'gender' => $account->gender(),
                'following_requested_at' => !is_null($account->followingRequestedAt())
                    ? $account->followingRequestedAt()->format('Y-m-d H:i:s')
                    : null,
                'updated_at' => !is_null($account->updatedAt())
                    ? $account->updatedAt()->format('Y-m-d H:i:s')
                    : null
            ]
        );
    }

    /**
     * @param Account $account
     * @throws AccountExistsWithSameUsernameException
     */
    public function store(Account $account): void
    {
        $this->assertNotExistsWithSameUsername($account);

        $document = $this->transformToDocument($account);

        $this->type->addDocuments([$document]);
        $this->index->flush();
        $this->index->refresh();
    }

    /**
     * @param string $username
     * @return Account
     * @throws AccountNotFoundException
     */
    public function byUsername(string $username): Account
    {
        $query = new Query\Match();
        $query->setField('username', $username);

        $boolQuery = new Query\BoolQuery();
        $boolQuery->addMust($query);

//        var_dump(json_encode($boolQuery->toArray()));

        $result = $this->type->search($boolQuery);
        $documents = $result->getDocuments();
        if (empty($documents)) {
            throw new AccountNotFoundException('ACCOUNT NOT FOUND FOR USERNAME: ' . $username);
        }

        return Account::createFromEsDocument($documents[0]);
    }

    /**
     * @param Account $account
     * @throws AccountExistsWithSameUsernameException
     */
    private function assertNotExistsWithSameUsername(Account $account): void
    {
        try {
            $entity = $this->byUsername($account->username());
            if ($entity->id() !== $account->id()) {
                throw new AccountExistsWithSameUsernameException('ACCOUNT WITH SAME USERNAME: ' . $account->username());
            }
            return;
        } catch (AccountNotFoundException $exception) {
            return;
        }
    }

    /**
     * @param int $size
     * @return array
     * @throws AccountNotFoundException
     */
    public function accountsToFollowOrderedByRating(int $size = 400): array
    {
        if ($size > 400) {
            throw new \InvalidArgumentException('SIZE CAN NOT BE GREATHER THAN 400');
        }
        $boolQuery = new BoolQuery();
        $nullFollowingRequestedAt = new BoolQuery();
        $existQuery = new Exists('following_requested_at');
        $nullFollowingRequestedAt->addMustNot($existQuery);
        $boolQuery->addShould($nullFollowingRequestedAt);

        $elasticaQuery = new Query();
        $elasticaQuery->addSort(['following_rating' => 'desc']);
        $elasticaQuery->setSize($size);
        $elasticaQuery->setQuery($boolQuery);

//        var_dump(json_encode($elasticaQuery->toArray()));

        $result = $this->type->search($elasticaQuery);
        $documents = $result->getDocuments();
        if (empty($documents)) {
            throw new AccountNotFoundException('ACCOUNT NOT FOUND');
        }
        $accounts = [];

        foreach ($documents as $document) {
            $accounts[] = Account::createFromEsDocument($document);
        }

        return $accounts;
    }
}