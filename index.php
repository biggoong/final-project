<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);

include 'core/core.php';
include 'core/controller.php';
include 'core/model.php';
include 'core/view.php';
include 'config.php';

$core = new Core();
$core->start();
?>
