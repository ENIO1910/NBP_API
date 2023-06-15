<?php
declare(strict_types=1);

namespace App\Controller;
class NbpApi
{
    private $apiUrl = 'https://api.nbp.pl/api/exchangerates/';

    public function getExchangeRates(string $table = 'A'): array
    {
        $url = "{$this->apiUrl}/tables/{$table}?format=json";
        $response = $this->fetchDataFromApi($url);

        if ($response !== false) {
            $data = json_decode($response, true);
            return $data[0]['rates'];
        }

        return [];
    }

    private function fetchDataFromApi(string $url): string|false
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception('Błąd połączenia z API NBP.');
        }

        curl_close($curl);

        return $response;
    }
}
