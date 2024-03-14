<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

session_start();

use Classes\Models\Category as Category;
use Classes\Models\User;
use Classes\Others\Utility as Utility;

$categoryList = Category::getAll();

User::login();
User::logout();
Utility::renderView('login', ["categoryList" => $categoryList]);
