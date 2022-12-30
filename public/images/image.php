<?php
$page = isset($_GET['page']) ? $_GET['page'] : '../../dummy.php';

include($page . ".php");
