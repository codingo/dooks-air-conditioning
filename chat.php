<?php
	session_start();
	require 'helpers.php';

	if(!isset($_SESSION['user_id'])) {
		redirect('index.html');
	}

	$user = $_SESSION['user_id'];
  $cookie_user = $_COOKIE['i_did_it_for_the_cookie'];

	$msg = file_get_contents('php://input');
	$flag = "flag{close-the-door}";
	$commands = array(	array("command"=> "hello", "msg"=>"Say 'Hi' to support"), 
						array("command" => "goodbye", "msg" => "End the session."), 
						array("command" => "changes", "msg" => "Ask support to tell you about recent product changes."), 
						array("command" => "joke", "msg" => "Have support tell you a joke!"), 
						array("command" =>"readflag", "msg" => "Ask support nicely for the flag."), 
						array("command" =>"help", "msg" => "Prints out a list of commands"));
	$jokes = array(	"Why is Peter Pan always flying? He neverlands." ,
					"My girlfriend yelled at me today saying, \"You weren't even listening just now, were you?! I thought, \"Man, what a weird way to start a conversation.\"", 
					"I used to have a job collecting leaves. I was raking it in.",
					"What's the leading cause of dry skin? Towels.",
					"I tell you what often gets overlooked - garden fences.",
					"I wear a stethoscope so that in a medical emergency I can teach people a valuable lesson about assumptions.",
					"Toasters were the first form of pop-up notifications.",
					"I love sniffing my F1 key... don't worry though, I'm trying to get help.",
					"I just ate a frozen apple. Hardcore.",
					"RIP boiled water. You will be mist.",
					"You know what they say about cliffhangers...",
					"My server sings, it's a Dell.");

	switch(strtolower($msg)) {
		case "man":
		case "manual":
		case "help": 
			echo json_encode($commands);
			break;
		case "hi":
		case "hello":
			echo json_encode("Hey ".$user."! How can I help you today?");
			break;
		case "goodbye":
			echo json_encode("Well that's just fine then. You be like that.");
			break;
		case "joke":
			shuffle($jokes);
			echo json_encode($jokes[1]);
			break;		
		case "changes":
			echo json_encode("Now selling doors to help keep in the air!");
			break;
    case "readflag":
      if($cookie_user != "c5b5bdbdb829c9a86bdc8860f93ecd55")
      {
        echo json_encode("Only dook can do that!");
      }
      else
      {
        echo json_encode($flag);
      }
			break;
		default:
			echo json_encode("I am not sure how to help with '$msg'!");
	}	
?>
