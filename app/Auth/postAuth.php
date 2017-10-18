<?php
namespace App\Auth;
use App\Models\postTable as p;


class postAuth
{
	public function save($data)
	{
		p::create($data);
		return true;
	}
	
	public function get($track = null)
	{
		$data = p::select(["post.uid as uid", "post.track as track", "clone.access_token as access_token", "post.id_post as id_post"])
				->join("clone",
					[
						"clone.uid" => "post.uid"
					])
				->get();
		if ($track != null)
		{
			$data = p::select(["post.uid as uid", "post.track as track", "clone.access_token as access_token", "post.id_post as id_post"])
				->where([
					"post.track" => $track
				])
				->join("clone",
					[
						"clone.uid" => "post.uid"
					])
				->get();
		}

		return $data;
	}

	public function delByPost($post)
	{
		$data = p::where([
				"id_post" => $post
			])->delete();

		return $data;
	}

	public function delByTrack($track)
	{
		$data = p::where([
			"track" => $track	
		])->delete();
		return $data;
	}

	public function delAll()
	{
		$data = p::delete();
		return $data;
	}
}