<?php
/**
 * Demo Data Import Script
 * This script imports the SQL dump file into the database
 */

require_once 'vendor/autoload.php';

// Load Laravel application
$app    = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

echo "Starting demo data import...\n";

try {
    // Read the SQL dump file
    $sqlFile = 'Database - multivendor_ecommerce/multivendor_ecommerce database - SQL Dump File - phpMyAdmin Export.sql';

    if (! File::exists($sqlFile)) {
        throw new Exception("SQL file not found: {$sqlFile}");
    }

    echo "Reading SQL file: {$sqlFile}\n";
    $sql = File::get($sqlFile);

                                                                  // Remove comments and split by semicolons
    $sql = preg_replace('/^--.*$/m', '', $sql);                   // Remove line comments
    $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);              // Remove block comments
    $sql = preg_replace('/^\s*SET.*$/m', '', $sql);               // Remove SET statements
    $sql = preg_replace('/^\s*START TRANSACTION.*$/m', '', $sql); // Remove transaction statements
    $sql = preg_replace('/^\s*COMMIT.*$/m', '', $sql);            // Remove commit statements

    // Split into individual statements
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function ($stmt) {
            return ! empty($stmt) && ! preg_match('/^\s*$/', $stmt);
        }
    );

    echo "Found " . count($statements) . " SQL statements\n";

    // Disable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=0');

    // Execute each statement
    $successCount = 0;
    $errorCount   = 0;

    foreach ($statements as $index => $statement) {
        try {
            // Skip problematic statements
            if (preg_match('/^\s*(\/\*|--|CREATE DATABASE|USE |SET |START|COMMIT)/i', $statement)) {
                continue;
            }

            DB::statement($statement);
            $successCount++;

            if ($successCount % 10 == 0) {
                echo "Executed {$successCount} statements...\n";
            }

        } catch (Exception $e) {
            $errorCount++;
            echo "Error in statement " . ($index + 1) . ": " . $e->getMessage() . "\n";
            // Continue with next statement
        }
    }

    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    echo "\nImport completed!\n";
    echo "Successfully executed: {$successCount} statements\n";
    echo "Errors encountered: {$errorCount} statements\n";

    // Verify import by checking some tables
    echo "\nVerifying import:\n";
    $tables = ['users', 'products', 'categories', 'vendors', 'brands', 'admins'];

    foreach ($tables as $table) {
        try {
            $count = DB::table($table)->count();
            echo "- {$table}: {$count} records\n";
        } catch (Exception $e) {
            echo "- {$table}: Error - " . $e->getMessage() . "\n";
        }
    }

} catch (Exception $e) {
    echo "Import failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\nDemo data import completed successfully!\n";
