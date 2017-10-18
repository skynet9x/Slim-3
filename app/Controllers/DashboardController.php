<?php
namespace App\Controllers;

use Respect\Validation\Validator as v;

class DashboardController extends Controller
{
	public function view($request, $response)
	{
		$this->view->getEnvironment()->addGlobal('action', 'dashboard');
		return $this->view->render($response, "home.html");
	}
}	