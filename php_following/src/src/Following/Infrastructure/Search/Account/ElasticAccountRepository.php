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

class ElasticAccountRepository implements AccountRepository
{
    /** @var Client $client */
    private Client $client;
    /** @var Index $index */
    private Index $index;


    public function __construct(Client $client, string $indexName)
    {
        $this->client = $client;
        $this->index = $this->client->getIndex($indexName);

        if (!$this->index->exists()) {
            $this->index->create([
                "settings" => [
                    "number_of_shards" => 3,
                    "number_of_replicas" => 2
                ]
            ]);
        }
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

        $this->index->addDocuments([$document]);
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

        $result = $this->index->search($boolQuery);
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
}