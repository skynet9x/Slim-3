<?php
use App\Middleware\LoginMiddleware;
use App\Middleware\UserServerMiddleware;
use App\Middleware\CsrfViewMiddleware;


$app->group("", function ()
{
	$this->get("/dashboard", 'DashboardController:view')->setName("dashboard.view");
	
	$this->get("/fb-profile", 'CloneController:view')->setName("fb.profile.view");

	$this->get("/clone/data", "CloneController:data")->setName("clone.data");

	$this->post("/clone/check/{uid}", "CloneController:infoUpdate")->setName("clone.check");

	$this->get("/clone/data/{uid}", "CloneController:getCloneByUid")->setName("clone.data.uid");

	$this->post("/clone/update/post", "CloneController:getUpdateSugget")->setName("clone.update.post");

	$this->get("/clone/post/get", "CloneController:getPostRun")->setName("clone.post.get");

	$this->get("/post/view", "PostController:view")->setName("post.view");

	$this->post("/post/save", "PostController:save")->setName("post.save");

	$this->get("/post/data/get", "PostController:getByTrack")->setName("post.data.get");

	$this->post("/post/delete", "PostController:delByPost")->setName("post.del.post");

	$this->post("/uid/save", "UidController:saveUid")->setName("uid.save");

	$this->get("/uid/get", "UidController:getUidByCountry")->setName("uid.get");

	$this->get("/clone/backup", "CloneController:backupClone");

	$this->post("/clone/add", "CloneController:add_2")->setName("clone.add");

	$this->get("/task", "TaskProfileController:view")->setName("task.view");
	
})->add(new UserServerMiddleware($container));

$app->group("", function ()
{
	$this->get("/login", "LoginController:view")->setName("login.view");

	$this->post("/login", "LoginController:submit")->setName("login.submit");

	$this->get("/register", "LoginController:register")->setName("register.view");

	$this->post("/register", "LoginController:registerSubmit")->setName("register.submit");
})->add(new App\Middleware\CsrfViewMiddleware($container))->add($container->csrf)->add(new LoginMiddleware($container));