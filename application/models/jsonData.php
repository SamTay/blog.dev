<?php

header("content-type:application/json");

try {
	//Session Data
	$msg = SessionModel::get('msg');
	$msgTone = SessionModel::get('msg-tone');
	$user = SessionModel::get('user');
	unset($_SESSION['msg']);
	unset($_SESSION['msg-tone']);

	//Config Data
	$config = Config::getConfig();
	$admin = $config->get('admin','username');

	//Registry Data
	$registry = Registry::getInstance();
	$success = $registry->success;
	$commentText = ($registry->comment) ? $registry->comment->comment : false;
	$commentCreated = ($registry->comment) ? $registry->comment->created : false;

	$access = ($user) ? 'user' : 'anonymous';
	if ($user == $admin) {
		$access = 'admin';
	}

	$keys = array(
		'success',
		'msg',
		'user',
		'access',
		'commentText',
		'commentCreated'
	);

	$data = array();
	$data['msgTone'] = ($msgTone) ? $msgTone : "success";
	foreach($keys as $key) {
		if ($$key) {
			$data[$key] = $$key;
		}
	}
} catch (Exception $e) {
	echo ($e->getMessage());
}

echo json_encode($data);