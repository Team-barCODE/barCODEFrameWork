<?php

require '../bootstrap.php';
require '../BaseApplication.php';

$app = new BaseApplication(false);
$test = $app->test();

var_dump($test);

echo "Hello World!";
