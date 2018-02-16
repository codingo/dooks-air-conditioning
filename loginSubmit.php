<?php
	require 'helpers.php';
	session_start();

	if(!$_POST['username']) {
		redirect('index.html');
	}
  
  if($_POST['username'] == "dook")  {
    redirect('index.html');
  }

  $_SESSION['user_id'] = $_POST['username'];
  setcookie("i_did_it_for_the_cookie", md5($_POST['username']), time()+(86400*30), "/");
	redirect('support.php');
?>
