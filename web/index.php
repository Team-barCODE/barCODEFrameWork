<?php

require '../bootstrap.php';
require '../MiniBlogApplication.php';

$app = new MiniBlogApplication(false);
var_dump($app->test());
// echo 'test';