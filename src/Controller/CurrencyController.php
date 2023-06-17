<?php

declare(strict_types=1);

namespace App\Controller;

class CurrencyController extends AbstractController
{
    private $apiUrl = 'http://api.nbp.pl/api/exchangerates/tables/a/';

    public function createAction(): void
    {
        if ($this->request->hasPost()) {
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];
            $this->noteModel->create($noteData);
            $this->redirect('/', ['before' => 'created']);
        }

        $this->view->render('create');
    }

    public function showAction(): void
    {
        $this->view->render(
            'show',
            ['note' => $this->getCurrency()]
        );
    }

    public function listAction(): void
    {
        $list = $this->getCurrencyTable();
        $effectiveDate = $list[0]['effectiveDate'];
        $rates = $list[0]['rates'];

        $currencyRates = [];
        foreach ($rates as $currencyRate) {
            $currencyRates[] = [
                'name' => $currencyRate['currency'],
                'code' => $currencyRate['code'],
                'value' => $currencyRate['mid']
            ];
        }

        $this->view->render(
            'list', ['currencyRates' => $currencyRates, 'date' => $effectiveDate]
        );
    }

    public function editAction(): void
    {
        if ($this->request->isPost()) {
            $noteId = (int)$this->request->postParam('id');
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];
            $this->noteModel->edit($noteId, $noteData);
            $this->redirect('/', ['before' => 'edited']);
        }

        $this->view->render(
            'edit',
            ['note' => $this->getCurrency()]
        );
    }

    private function getCurrency(): array
    {
        $noteId = (int)$this->request->getParam('id');
        if (!$noteId) {
            $this->redirect('/', ['error' => 'missingNoteId']);
        }

        return $this->noteModel->get($noteId);
    }


    public function getCurrencyTable(): array
    {
        $response = $this->fetchDataFromApi();

        if ($response !== false) {
            $data = json_decode($response, true);
            return $data;
        }

        return [];
    }

    private function fetchDataFromApi(): string|false
    {
        $curl = curl_init($this->apiUrl);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if ($response === false) {
            throw new \Exception('Błąd połączenia z API NBP.');
        }

        curl_close($curl);

        return $response;
    }
}
