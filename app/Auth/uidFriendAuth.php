<?php
namespace App\Auth;
use App\Models\uidFriendTable as uft;


class uidFriendAuth
{
	public function save($data)
	{
		$count = uft::where([
				"uid" => $data["uid"]
			])->count();
		if (!$count)
		{
			uft::create($data);
		}

		return true;
	}

	public function getRequest($country)
	{
		$data = uft::where([
				"status" => 1,
				"country" => $country
			])->first();
		if (!empty($data))
		{	
			uft::where([
				"uid" => $data->uid
			])->update(["status" => 0]);
		} else {
			uft::update(["status" => 1]);

			$data = uft::where([
				"status" => 1,
				"country" => $country
			])->first();

			uft::where([
				"uid" => $data->uid
			])->update(["status" => 0]);
		}
		

		return $data;
	}
}