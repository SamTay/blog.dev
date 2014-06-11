<?php

header("content-type:application/json");

$sessionMsg = SessionModel::get('msg');
$sessionMsgTone = SessionModel::get('msg-tone');
unset($_SESSION['msg']);
unset($_SESSION['msg-tone']);

$user = SessionModel::get('user');

$config = Config::getConfig();
$admin = $config->get('admin','username');

ob_start();
include(ROOT.DS.'templates'.DS.'header'.DS.'userOptions.php');
$headerHTML = ob_get_contents();
ob_end_clean();

if ($admin == $user) {
	ob_start();
	include(ROOT.DS.'templates'.DS.'header'.DS.'adminOptions.php');
	$headerHTML = ob_get_contents() . $headerHTML;
	ob_end_clean();
}

$data = array(
	'msg' => '<strong><span id="msgSet">'.$sessionMsg.'</span></strong>',
	'msgTone' => ($sessionMsgTone) ? $sessionMsgTone : 'success',
	'headerOptions' => $headerHTML
);

echo json_encode($data);

