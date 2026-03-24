<?php

session_start();


if (($_GET['page'] ?? '') === 'fichier') {
    define('BASE_PATH', dirname(__DIR__));
    define('BASE_URL', '/projet_BTS/public/');
    require_once BASE_PATH . '/app/Config/db.php';
    require_once BASE_PATH . '/app/Helpers/sessionsHelper.php';
    require_once BASE_PATH . '/app/Models/SignalementModel.php';
    require_once BASE_PATH . '/app/Controllers/SignalementController.php';
    $controller = new SignalementController();
    $controller->servirFichier();
    exit;
}
// 1. Constantes globales
define('BASE_PATH', dirname(__DIR__)); 
define('BASE_URL', '/projet_BTS/public/');

// 2. Charger les routes
$routes = require BASE_PATH . '/app/Config/routes.php';

// 3. Route demandée
$page = $_GET['page'] ?? 'home';

// 4. Vérifier si la route existe
if (!isset($routes[$page])) {
    http_response_code(404);
    echo '404 - Page introuvable';
    exit;
}

// 5. Découper Controller@method
[$controllerName, $method] = explode('@', $routes[$page]);

// 6. Charger le controller
$controllerFile = BASE_PATH . "/app/Controllers/$controllerName.php";

if (!file_exists($controllerFile)) {
    die("Controller introuvable");
}

require_once $controllerFile;

// 7. Exécuter la méthode
$controller = new $controllerName();
$controller->$method();
