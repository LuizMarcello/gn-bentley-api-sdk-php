<?php

session_start();
$_SESSION['chave'] = $_POST['payment_token'];