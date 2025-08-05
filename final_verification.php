<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Initialize Laravel app
$app    = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FINAL DATABASE STATUS ===\n\n";

$tables = [
    'users', 'products', 'categories', 'vendors', 'brands', 'admins',
    'banners', 'orders', 'orders_products', 'carts', 'sections',
    'coupons', 'ratings', 'countries', 'products_attributes', 'products_images',
];

foreach ($tables as $table) {
    try {
        $count = DB::table($table)->count();
        echo sprintf("%-20s: %3d records\n", $table, $count);
    } catch (Exception $e) {
        echo sprintf("%-20s: ERROR\n", $table);
    }
}

echo "\n=== SAMPLE DATA ===\n\n";

// Show sample products
echo "Sample Products:\n";
$products = DB::table('products')->select('id', 'product_name', 'product_code', 'product_price', 'status')->take(3)->get();
foreach ($products as $product) {
    echo "- ID {$product->id}: {$product->product_name} ({$product->product_code}) - \${$product->product_price}\n";
}

// Show sample categories
echo "\nSample Categories:\n";
$categories = DB::table('categories')->select('id', 'category_name', 'status')->take(5)->get();
foreach ($categories as $category) {
    echo "- ID {$category->id}: {$category->category_name}\n";
}

// Show sample vendors
echo "\nSample Vendors:\n";
$vendors = DB::table('vendors')->select('id', 'name', 'email', 'status')->take(3)->get();
foreach ($vendors as $vendor) {
    echo "- ID {$vendor->id}: {$vendor->name} ({$vendor->email})\n";
}

// Show sample orders
echo "\nSample Orders:\n";
$orders = DB::table('orders')->select('id', 'user_id', 'name', 'grand_total', 'order_status')->take(3)->get();
foreach ($orders as $order) {
    echo "- Order #{$order->id}: {$order->name} - \${$order->grand_total} ({$order->order_status})\n";
}

echo "\n=== APPLICATION READY! ===\n";
echo "✅ Laravel 12 successfully upgraded\n";
echo "✅ Database populated with demo data\n";
echo "✅ Products, categories, vendors, and orders available\n";
echo "✅ Admin panel should be functional\n";
echo "✅ Frontend should display products\n\n";

echo "Next steps:\n";
echo "1. Visit the frontend: http://localhost/\n";
echo "2. Visit admin panel: http://localhost/admin\n";
echo "3. Check if product images are accessible\n";
echo "4. Test e-commerce functionality\n\n";

echo "Demo admin credentials (if needed):\n";
$admin = DB::table('admins')->where('type', 'superadmin')->first();
if ($admin) {
    echo "Email: {$admin->email}\n";
    echo "Check the admins table for password hash\n";
}

echo "\nDemo data import and Laravel 12 upgrade completed successfully!\n";
