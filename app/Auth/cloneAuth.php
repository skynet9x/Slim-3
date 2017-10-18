<?php
namespace App\Auth;
use App\Models\cloneTable as ct;
use App\Models\postTable as p;

class cloneAuth
{
	public function save($data)
	{
		$ary = ct::where([
				"uid" => $data["uid"]
			])->first();
		if (!empty($ary))
		{
			ct::where([
				"uid" => $data["uid"]
			])->update($data);
		} else {
			ct::create($data);
		}

		return true;
	}

	public function get($limit = 100, $offset = 0)
	{
		$data = ct::limit($limit)->offset($offset)->get();
		return $data;
	}

	public function getRule($p, $where = null, $l = 50)
	{
		// get start //
		$s = ($p - 1) * $l;
		if ($where == null)
		{
			$data = ct::where([
					"user" => $_SESSION["user"]
				])->limit($l)->offset(0)->get();
		} else {
			$where["user"] = $_SESSION["user"];

			$data = ct::where($where)->limit($l)->offset($s)->get();
		}
		
		return $data;
	}

	public function getByUid($uid)
	{
		$data = ct::where([
				"uid" => $uid
			])->first();

		return (!empty($data)) ? $data : false;
	}

	public function getClonePostNull()
	{
		$data = ct::where([
				"type" => "post",
				"status" => 1
			])->whereNotIn( 'uid', 
				ct::select('post')
				->where([
					"status" => 1
				])->get()
			)->first();
		return (!empty($data)) ? $data : false;
	}

	public function getCount($where)
	{
		$data = ct::where($where)->count();
		return $data;
	}

	public function getClonePost()
	{
		$data = ct::where([
				"type" => "post",
				"status" => 1
			])->whereIn( 'uid', 
				ct::select('post')
				->where([
					"status" => 1
				])->get()
			)->get();
		return $data;
	}

	public function getCloneProfilePost()
	{

	}

	public function getCloneProfilePostNull()
	{
		$data = ct::where([
				"post" => "",
				"status" => 1,
				"type" => "profile"
			])->where("friend", ">", "700")->first();

		return (!empty($data)) ? $data : false;
	}

	public function getCloneProfilePostNullAll($limit)
	{
		$data = ct::where([
				"post" => "",
				"status" => 1,
				"type" => "profile"
			])->where("friend", ">", "700")->limit($limit)->get();

		return $data;
	}

	public function getCloneProfileByPost($uid)
	{
		$data = ct::where([
				"post" => $uid,
				"status" => 1,
				"type" => "profile"
			])->get();

		return (!empty($data)) ? $data : false;
	}

	public function getClonePostByTrack($track)
	{
		$data = ct::where([
				"status" => 1,
				"type" => "post"
			])->whereIn( 'uid', 
				ct::select('post')
				->where([
					"status" => 1
				])->get()
			)->whereNotIn("uid", p::select("uid")->where([ "track" => $track ]))->get();
		return (!empty($data)) ? $data : false;
	}

	public function getBackup()
	{
		$data = ct::where([
				"type" => "profile",
				"status" => 1
			])->get();

		return $data;
	}
}