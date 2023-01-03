<?php
session_start();

// making clean url using .htaccess
// www.website.com/index.php?page=login
// www.website.com/login

//include all functions
require("../private/functions.php");

$page = isset($_GET['url']) ? $_GET['url'] : "home";
// print_r($_GET);

// Checking available files
$folder = "../private/";
$files = glob($folder . "*.php");
$filename = $folder . $page . ".php";
// echo "<pre>";
// print_r($files);
// echo "</pre>";

if (in_array($filename, $files)) {
    include($filename);
} else {
    include "../private/404.php";
}
