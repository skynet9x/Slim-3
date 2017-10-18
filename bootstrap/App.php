<?php
use App\Middleware\CsrfViewMiddleware;
use Respect\Validation\Validator as v;

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true,

		'db' => [
			'driver' => 'mysql',
			'host' => 'localhost', //107.180.0.216
			'database' => 'dataclone', //clientdb_1102
			'username' => 'root', //clientdb_1102
			'password' => '', //tlE4]-7Z51*I
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix' => ''
		]
	],
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection($container["settings"]["db"]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
	return $capsule;
};

$container['view'] = function ($container) {

	$view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
			'cache' => false
		]);

	$view->addExtension(new \Slim\Views\TwigExtension(
			$container->router,

			$container->request->getUri()
		));
	
	return $view;
};

$container["CloneController"] = function ($container)
{
	return new App\Controllers\CloneController($container);
};

$container["LoginController"] = function ($container)
{
	return new App\Controllers\LoginController($container);
};

$container["DashboardController"] = function ($container)
{
	return new App\Controllers\DashboardController($container);
};

$container["TaskProfileController"] = function ($container)
{
	return new App\Controllers\TaskProfileController($container);
};

$container["cloneAuth"] = function ()
{
	return new App\Auth\cloneAuth;
};

$container["facebookAuth"] = function ()
{
	return new App\Auth\facebookAuth;
};

$container["postAuth"] = function ()
{
	return new App\Auth\postAuth;
};

$container["uidFriendAuth"] = function ()
{
	return new App\Auth\uidFriendAuth;
};

$container["AuthUsers"] = function ()
{
	return new App\Auth\AuthUsers;
};

$container["PostController"] = function ($container)
{
	return new App\Controllers\PostController($container);
};

$container["UidController"] = function ($container)
{
	return new App\Controllers\UidController($container);
};

$container["csrf"] = function ($container)
{
	return new \Slim\Csrf\Guard;
};

$container["validator"] = function ()
{
	return new App\Validation\Validator;
};

v::with('App\\Validation\\Rules\\');


require __DIR__ . '/../app/routes.php';

