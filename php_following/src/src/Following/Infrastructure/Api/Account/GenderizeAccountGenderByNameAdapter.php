<?php


namespace App\Following\Infrastructure\Api\Account;


use App\Following\Domain\Model\Account\AccountGenderByName;
use GuzzleHttp\Client;

class GenderizeAccountGenderByNameAdapter implements AccountGenderByName
{
    const TIMEOUT = 5;


    public function detectGender(string $name): ?string
    {
        try {
            $client = new Client([
                'base_uri' => 'https://api.genderize.io',
                'http_errors' => true
            ]);
            $uri = '?name=' . $name;

            $response = $client->get($uri);

            $data = json_decode($response->getBody()->getContents(), true);

            $gender = $data['gender'];

            if ($gender == 'male' || $gender == 'female') {
                return $gender;
            }

            return null;
        } catch (\Exception $exception) {
            echo "ERROR NAMSOR: " . $exception->getMessage();
            return null;
        }
    }
}