<?php
require_once('models/Paynow.php');
$tester = new Paynow();
$tester->chargeCreditCard($_GET["pay"]);
die();