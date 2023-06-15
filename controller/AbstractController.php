<?php

declare(strict_types=1);


namespace App\Controller;



use App\Exception\ConfigurationException;
use App\Request;
use App\View;

abstract class AbstractController
{

    private static array $configuration = [];
    protected const DEFAULT_ACTION = 'list';
    protected Request $request;
    protected View $view;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }


    public function __construct(Request $request)
    {
        if (empty(self::$configuration['db'])) {
            throw new ConfigurationException("Configuration error");
        }
        $this->noteModel = new NoteModel(self::$configuration['db']);

        $this->request = $request;
        $this->view = new View();
    }

    /**
     * check out the view
     * @return void
     */
    public function run(): void
    {
        $action = $this->action();

        if (!method_exists($this, $action)) {
            $action = self::DEFAULT_ACTION ;
        }
        $this->$action();
    }

    private function action(): string
    {
        return $this->request->getParam( 'action',self::DEFAULT_ACTION);
    }

    protected function redirect(string $to, array $params): void
    {
        $location = $to;

        if (count($params)) {
            $queryParams = [];
            foreach ($params as $key => $value) {
                $queryParams[] = urlencode($key) . '=' . urlencode($value);
            }

            $queryParams = implode('&', $queryParams);
            $location .= '?' . $queryParams;
        }

        header("Location: $location");
        exit;
    }

}