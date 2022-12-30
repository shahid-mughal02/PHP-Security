<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'dummy.php';

//listing current directory files
$folder = "";
$files = glob($folder . "*.php");
$files[] = "hello.php";
$files[] = "demo.php";
$files[] = "nice.php";
print_r($files);

//check .php file available in the current directory
if (in_array($page, $files)) {
    include($page);
} else {
    echo "Coudn't find the files";
}

//This  will return the PHP Version info
// http://localhost/php-security/index.php?page=info.txt
