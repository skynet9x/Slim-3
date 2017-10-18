<?php
namespace App\Middleware;

class UserServerMiddleware extends Middleware
{
	public function __invoke ($request, $response, $next) {

		if (!$this->container->AuthUsers->check())
		{
			return $response->withRedirect($this->container->router->pathFor('login.view'));
		}

		$response = $next($request, $response);

		return $response;
	}
}