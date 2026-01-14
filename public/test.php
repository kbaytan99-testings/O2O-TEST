<?php
// Simple test to check if PHP and Symfony are working
echo "PHP is working!\n";
echo "PHP Version: " . PHP_VERSION . "\n";

require __DIR__.'/../vendor/autoload.php';
echo "Autoload works!\n";

use App\Kernel;
echo "Kernel class loaded!\n";

echo "\nEverything looks good!";
