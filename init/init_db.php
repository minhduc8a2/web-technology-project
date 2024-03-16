<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "webtechdb";

$pdo = new PDO("mysql:host=$servername", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->prepare("CREATE DATABASE IF NOT EXISTS $dbname")->execute();
$pdo->prepare("use $dbname")->execute();
