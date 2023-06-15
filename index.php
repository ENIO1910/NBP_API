<?php
declare(strict_types=1);

use App\Controller\AbstractController;
use App\Controller\Controller;
use App\Controller\NbpApi;
use App\NbpController;
use App\Request;


require_once 'database/connect.php';
require_once("controller/Request.php");
require_once("controller/NbpController.php");
require_once("controller/NbpApi.php");
require_once("templates/layout.php");

$configuration = require_once("config/config.php");
$request = new Request($_GET, $_POST, $_SERVER);

$nbpApi = new NbpController();
var_dump($nbpApi->getCurrencyTable());
