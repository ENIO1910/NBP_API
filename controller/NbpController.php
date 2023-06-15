<?php
declare(strict_types=1);

namespace App;
class NbpController
{
    private $apiUrl = 'http://api.nbp.pl/api/exchangerates/tables/a/';

    public function getCurrencyTable(): array
    {
        try {
            $response = $this->fetchDataFromApi();

            if ($response !== false) {
                $data = json_decode($response, true);
                return $data;
            }
        } catch (Exception $e) {
            // Obsługa błędu połączenia
            // ...
        }

        return [];
    }

    private function fetchDataFromApi(): string|false
    {
        $curl = curl_init($this->apiUrl);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception('Błąd połączenia z API NBP.');
        }

        curl_close($curl);

        return $response;
    }
}
