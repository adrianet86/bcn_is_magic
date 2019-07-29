<?php


namespace App\Following\Application\Service\Account;


use App\Following\Domain\Model\Account\Account;
use App\Following\Domain\Model\Account\AccountGenderByName;
use App\Following\Domain\Model\Account\AccountNotFoundException;
use App\Following\Domain\Model\Account\AccountProvider;
use App\Following\Domain\Model\Account\AccountRepository;

class RecollectAccountsFromFollowersService
{
    const GAP = 200;
    const WAIT = 1;

    private AccountRepository $accountRepository;
    private AccountProvider $accountProvider;
    private AccountGenderByName $accountGenderByName;

    public function __construct(
        AccountRepository $accountRepository,
        AccountProvider $accountProvider,
        AccountGenderByName $accountGenderByName
    )
    {
        $this->accountRepository = $accountRepository;
        $this->accountProvider = $accountProvider;
        $this->accountGenderByName = $accountGenderByName;
    }

    /**
     * @param RecollectAccountsFromFollowersRequest $request
     * @throws \App\Following\Domain\Model\Account\AccountExistsWithSameUsernameException
     */
    public function execute($request)
    {
        $accountUsername = $request->accountUsername();

        $total = $this->accountProvider->totalByAccountFollowers($accountUsername) + self::GAP;

        for ($page = 1; ($page * self::GAP) <= $total; $page++) {

            $accounts = $this->accountProvider->byAccountFollowers($accountUsername, $page);

            if (!empty($accounts)) {
                /** @var Account $accountToSave */
                foreach ($accounts as $accountToSave) {
                    try {
//                        sleep(self::WAIT);
//                        $accountToSave->setGender(
//                            $this->accountGenderByName->detectGender($accountToSave->name())
//                        );
                        $accountFromRepository = $this->accountRepository->byUsername($accountToSave->username());
                        $this->updateAccount($accountFromRepository, $accountToSave);
                    } catch (AccountNotFoundException $exception) {
                        $this->accountRepository->store($accountToSave);
                    }
                }
            }
        }
    }

    private function updateAccount(Account $accountFromRepository, Account $accountToSave): void
    {
        $accountFromRepository->updateIgInfo(
            $accountToSave->name(),
            $accountToSave->isPrivate(),
            $accountToSave->hasProfilePicture(),
            $accountToSave->isBusiness(),
            $accountToSave->followers(),
            $accountToSave->following(),
            $accountToSave->biography(),
            $accountToSave->mediaCount()
        );
        $this->accountRepository->store($accountFromRepository);
    }
}