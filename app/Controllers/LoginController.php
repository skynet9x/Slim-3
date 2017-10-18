<?php
namespace App\Controllers;

use Respect\Validation\Validator as v;

class LoginController extends Controller
{
	public function view($request, $response)
	{
		return $this->view->render($response, "login.html");
	}

	public function submit($request, $response)
	{
		$validation = $this->validator->validate($request,
		[
			'username' => v::noWhitespace()->notEmpty()->Length(6, 200)->UserRegex(),
			'password' => v::noWhitespace()->notEmpty()->Length(6, 200)
		]);

		if ($validation->failed())
		{
			return $response->withJson([
					'errors' => ['validation' => $validation->errors],
					'fail' => $validation->failed(),
					'cross' => $_SESSION["cross_element"]
				], 400);
		}
		$ruslt = $this->AuthUsers->Login($request);
		if ($ruslt->failed())
		{
			return $response->withJson([
					'errors' => ['validation' => $ruslt->error_msg],
					'cross' => $_SESSION["cross_element"]
				], 400);
		};

		return $response->withJson(["login" => !$ruslt->failed()], 200);
	}

	public function register($request, $response)
	{
		return $this->view->render($response, 'register.html');
	}

	public function registerSubmit($request, $response)
	{

		$validation = $this->validator->validate($request,
		[
			'email' => v::noWhitespace()->notEmpty()->email()->EmailAvailable(),
			'username' => v::noWhitespace()->notEmpty()->Length(6, 200)->UserRegex(),
			'password' => v::noWhitespace()->notEmpty()->Length(6, 200)->regex("/^". $request->getParam("password_re") ."$/"),
			'full_name' => v::notEmpty()->Length(6, 200)
		]);

		if ($validation->failed())
		{
			return $response->withJson([
					'errors' => ['validation' => $validation->errors],
					'fail' => $validation->failed(),
					'cross' => $_SESSION["cross_element"]
				], 400);
		}

		$data = $this->AuthUsers->Register($request);

		return $response->withJson([
			'user_new' => $data,
			'fail' => $validation->failed()
		], 200);
	}
}	