<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Initialize Laravel app
$app    = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking products table structure:\n";

try {
    $columns = Schema::getColumnListing('products');
    echo "Products table columns:\n";
    foreach ($columns as $column) {
        echo "- $column\n";
    }

    echo "\nSample products query:\n";
    $products = DB::table('products')->take(3)->get();
    echo "Found " . $products->count() . " products\n";

    // Let's see what's in the SQL file for products
    echo "\nChecking if products data exists in SQL file...\n";
    $sqlFile = 'Database - multivendor_ecommerce/multivendor_ecommerce database - SQL Dump File - phpMyAdmin Export.sql';
    $content = file_get_contents($sqlFile);

    // Look for products INSERT statements
    if (preg_match('/INSERT INTO `products`/i', $content)) {
        echo "Products INSERT statements found in SQL file\n";

        // Extract the first product INSERT to see the column structure
        if (preg_match('/INSERT INTO `products` \(`([^`]+)`\) VALUES/i', $content, $matches)) {
            echo "SQL file products columns: " . $matches[1] . "\n";
        }
    } else {
        echo "No products INSERT statements found in SQL file\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nDone.\n";
