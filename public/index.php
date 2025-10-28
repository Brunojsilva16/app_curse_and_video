<?php
// Ativa exibição de erros (em desenvolvimento)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// --- NOVO: Define a raiz do projeto ---
define('ROOT_PATH', dirname(__DIR__));

use App\Core\Router;

// =======================
// Definição do BASE_URL
// =======================
$baseUrl = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
define("BASE_URL", $baseUrl);
define("VIEWS_PATH", ROOT_PATH . '/app/views'); // Caminho absoluto para as views

// $router = new App\Core\Router();
// =======================
// Autoload (Composer ou manual)
// =======================
require_once ROOT_PATH . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// =======================
// Definição das rotas
// =======================
$router = new Router();
require ROOT_PATH . '/app/Routes/routes.php';

// =======================
// Despacho da rota
// =======================
$url    = $_GET['url'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($url, $method);

