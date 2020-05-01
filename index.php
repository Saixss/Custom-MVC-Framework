<?php

session_start();
spl_autoload_register();

$projectRootTokens = explode("\\", __DIR__);
$projectRoot = array_pop($projectRootTokens);

$uri = $_SERVER["REQUEST_URI"];

$requestPath = substr($uri, strlen("/" . $projectRoot . "/"));

$params = explode("/", $requestPath);

$defaultRoutElements = parse_ini_file("Config\config.ini");

$controllerName = array_shift($params)?:$defaultRoutElements["default_controller_name"];
$actionName = array_shift($params)?:$defaultRoutElements["default_action_name"];

$mvcContext = new \Core\Mvc\MvcContext($controllerName, $actionName, $params, $requestPath);
$app = new Core\Application($mvcContext);

$app->registerDependency(Database\DatabaseInterface::class, Database\Database::class);
$app->registerDependency(Database\ORM\QueryBuilderInterface::class, Database\ORM\MySQLQueryBuilder::class);
$app->registerDependency(Core\TemplateInterface::class, Core\Template::class);
$app->registerDependency(Core\DataBinderInterface::class, Core\DataBinder::class);
$app->registerDependency(src\Repository\User\UserRepositoryInterface::class, src\Repository\User\UserRepository::class);
$app->registerDependency(src\Service\User\UserServiceInterface::class, src\Service\User\UserService::class);

try {
    $app->start();
} catch (Exception\RouteException $exception) {
    $host  = $_SERVER['HTTP_HOST'];

    include_once "error_404_page.php";
} catch (Exception $exception) {
    include_once "error_500_page.php";
}

