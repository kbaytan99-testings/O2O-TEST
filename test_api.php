<?php

$_SERVER['APP_ENV'] = 'dev';
$_SERVER['APP_DEBUG'] = '1';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/api/books?search=shakespeare';
$_SERVER['QUERY_STRING'] = 'search=shakespeare';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '8000';
$_SERVER['HTTP_HOST'] = 'localhost:8000';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__.'/public/index.php';

require __DIR__.'/public/index.php';
