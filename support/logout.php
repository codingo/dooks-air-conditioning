<?php
    session_start();
    require 'helpers.php';

    session_unset(); 
    session_destroy();
     
    redirect('index.html');
?>
