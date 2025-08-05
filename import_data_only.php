<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

// Initialize Laravel app
$app    = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting data-only import...\n";

// SQL file path
$sqlFile = 'Database - multivendor_ecommerce/multivendor_ecommerce database - SQL Dump File - phpMyAdmin Export.sql';

if (! File::exists($sqlFile)) {
    echo "SQL file not found: $sqlFile\n";
    exit(1);
}

echo "Reading SQL file: $sqlFile\n";

// Read SQL file content
$sql = File::get($sqlFile);

// Remove comments and normalize line endings
$sql = preg_replace('/--.*$/m', '', $sql);
$sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
$sql = str_replace("\r\n", "\n", $sql);

// Split into statements
$statements = array_filter(array_map('trim', explode(';', $sql)));

echo "Found " . count($statements) . " SQL statements\n";

// First, disable foreign key checks to avoid constraint issues
DB::statement('SET FOREIGN_KEY_CHECKS=0');

$successCount = 0;
$errorCount   = 0;

foreach ($statements as $index => $statement) {
    if (empty($statement)) {
        continue;
    }

    // Skip CREATE TABLE, ALTER TABLE, and other structure-related statements
    if (preg_match('/^\s*(CREATE TABLE|ALTER TABLE|DROP TABLE|CREATE UNIQUE INDEX|CREATE INDEX)/i', $statement)) {
        continue;
    }

    // Only process INSERT statements
    if (! preg_match('/^\s*INSERT\s+INTO/i', $statement)) {
        continue;
    }

    try {
        // Handle datetime format issues
        $statement = str_replace("'0000-00-00 00:00:00'", "NULL", $statement);

        DB::statement($statement);
        $successCount++;

        if ($successCount % 10 == 0) {
            echo "Executed $successCount INSERT statements...\n";
        }

    } catch (Exception $e) {
        $errorCount++;
        $errorMessage = $e->getMessage();

        // Only show first 100 chars of error for brevity
        if (strlen($errorMessage) > 100) {
            $errorMessage = substr($errorMessage, 0, 100) . '...';
        }

        echo "Error in INSERT statement " . ($index + 1) . ": $errorMessage\n";
    }
}

// Re-enable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS=1');

echo "\nData import completed!\n";
echo "Successfully executed: $successCount INSERT statements\n";
echo "Errors encountered: $errorCount statements\n";

// Verify the import by checking record counts
echo "\nVerifying import:\n";

$tables = [
    'users', 'products', 'categories', 'vendors', 'brands', 'admins',
    'banners', 'orders', 'orders_products', 'carts', 'sections',
    'coupons', 'ratings', 'countries',
];

foreach ($tables as $table) {
    try {
        $count = DB::table($table)->count();
        echo "- $table: $count records\n";
    } catch (Exception $e) {
        echo "- $table: Error checking count\n";
    }
}

echo "\nData import process completed!\n";
