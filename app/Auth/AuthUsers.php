<?php
namespace App\Auth;

use App\Controllers\Controller;
use App\Models\Users;

class AuthUsers
{
	protected $avatar = "/public/image/avatar-default.png";

	public $error_msg;

	public function check()
	{
		if (isset($_SESSION["user"]) && $_SESSION["user"] != "")
		{
			return !$this->emptyUser([
					"username" => $_SESSION["user"],
					"status" => 1
				]);
		}
		
		return false;
	}

	public function info()
	{

	}

	public function Login($request)
	{
		// validation //

		$data = $request->getParams();
		if ($this->emptyUser(["username" => $data["username"]]))
		{
			$this->error_msg["username"] = "Not Username.";
		} else {
			$tam = Users::where([
				"username" => $data["username"],
				"password" => md5($data["password"]),
				"status" => 1
			])->first();
			if (empty($tam))
			{
				$this->error_msg["password"] = "Not Password.";
			} else {
				$_SESSION["user"] = $tam->username;
				$_SESSION["pre"] = $tam->pre;
			}
		}

		return $this;
	}

	public function failed()
	{
		return !empty($this->error_msg);
	}

	public function Register($request)
	{
		$result = false;
		if (
			$this->emptyUser([
					"username" => $request->getParam('username')
				])) 
		{
			$data = [
				"username" => $request->getParam('username'),
				"password" => md5($request->getParam('password')),
				"full_name" => $request->getParam('full_name'),
				"email" => $request->getParam('email'),
				"status" => 0,
				"pre" => 2,
				"avatar" => $this->avatar
			];

			$result = Users::create($data);
			
		}

		return $result;
	}

	public function emptyUser($where)
	{
		$data = Users::where($where)->first();

		return empty($data);
	}
}