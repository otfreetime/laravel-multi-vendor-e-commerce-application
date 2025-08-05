<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Initialize Laravel app
$app    = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Manual products data insertion...\n";

// Clear existing products first
DB::table('products')->truncate();
DB::table('products_attributes')->truncate();
DB::table('products_images')->truncate();

echo "Cleared existing products data\n";

// Disable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS=0');

// Insert products manually with proper column mapping
$products = [
    [
        'id'               => 1,
        'section_id'       => 2,
        'category_id'      => 5,
        'brand_id'         => 7,
        'vendor_id'        => 0,
        'admin_id'         => 1,
        'admin_type'       => 'superadmin',
        'product_name'     => 'Redmi Note 11',
        'product_code'     => 'RN11',
        'product_color'    => 'Blue',
        'product_price'    => 15000,
        'product_discount' => 20,
        'product_weight'   => 500,
        'product_image'    => '91540.jpg',
        'product_video'    => '',
        'group_code'       => null,
        'description'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'meta_title'       => 'Redmi Note 11',
        'meta_keywords'    => 'redmi note 11',
        'meta_description' => 'Best price for Redmi Note 11',
        'is_featured'      => 'Yes',
        'is_bestseller'    => 'Yes',
        'status'           => 1,
        'created_at'       => now(),
        'updated_at'       => now(),
    ],
    [
        'id'               => 2,
        'section_id'       => 1,
        'category_id'      => 6,
        'brand_id'         => 2,
        'vendor_id'        => 0,
        'admin_id'         => 1,
        'admin_type'       => 'superadmin',
        'product_name'     => 'Red Casual T-Shirt',
        'product_code'     => 'RC001',
        'product_color'    => 'Red',
        'product_price'    => 1100,
        'product_discount' => 0,
        'product_weight'   => 200,
        'product_image'    => '95575.jpg',
        'product_video'    => '',
        'group_code'       => '100',
        'description'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'meta_title'       => null,
        'meta_keywords'    => null,
        'meta_description' => null,
        'is_featured'      => 'Yes',
        'is_bestseller'    => 'Yes',
        'status'           => 1,
        'created_at'       => now(),
        'updated_at'       => now(),
    ],
    [
        'id'               => 3,
        'section_id'       => 1,
        'category_id'      => 6,
        'brand_id'         => 1,
        'vendor_id'        => 0,
        'admin_id'         => 1,
        'admin_type'       => 'superadmin',
        'product_name'     => 'Arrow T-Shirt',
        'product_code'     => 'AT01',
        'product_color'    => 'Red',
        'product_price'    => 1500,
        'product_discount' => 0,
        'product_weight'   => 400,
        'product_image'    => '27416.jpg',
        'product_video'    => '880084420.mp4',
        'group_code'       => null,
        'description'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'meta_title'       => 'Pure Cotton T-shirt',
        'meta_keywords'    => 'cotton T-shirt, red T-shirt',
        'meta_description' => 'This is a high quality cotton T-shirt',
        'is_featured'      => 'No',
        'is_bestseller'    => 'Yes',
        'status'           => 1,
        'created_at'       => now(),
        'updated_at'       => now(),
    ],
    [
        'id'               => 4,
        'section_id'       => 1,
        'category_id'      => 6,
        'brand_id'         => 3,
        'vendor_id'        => 0,
        'admin_id'         => 1,
        'admin_type'       => 'superadmin',
        'product_name'     => 'Blue T-Shirt',
        'product_code'     => 'BT01',
        'product_color'    => 'Blue',
        'product_price'    => 2500,
        'product_discount' => 0,
        'product_weight'   => 0,
        'product_image'    => '58892.png',
        'product_video'    => null,
        'group_code'       => '100',
        'description'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'meta_title'       => null,
        'meta_keywords'    => null,
        'meta_description' => null,
        'is_featured'      => 'No',
        'is_bestseller'    => 'Yes',
        'status'           => 1,
        'created_at'       => now(),
        'updated_at'       => now(),
    ],
    [
        'id'               => 5,
        'section_id'       => 1,
        'category_id'      => 6,
        'brand_id'         => 2,
        'vendor_id'        => 0,
        'admin_id'         => 1,
        'admin_type'       => 'superadmin',
        'product_name'     => 'Green T-Shirt',
        'product_code'     => 'GT01',
        'product_color'    => 'Green',
        'product_price'    => 900,
        'product_discount' => 10,
        'product_weight'   => 100,
        'product_image'    => '79204.png',
        'product_video'    => null,
        'group_code'       => '100',
        'description'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'meta_title'       => null,
        'meta_keywords'    => null,
        'meta_description' => null,
        'is_featured'      => 'Yes',
        'is_bestseller'    => 'No',
        'status'           => 1,
        'created_at'       => now(),
        'updated_at'       => now(),
    ],
];

foreach ($products as $product) {
    DB::table('products')->insert($product);
    echo "Inserted product: {$product['product_name']}\n";
}

// Insert product attributes (sizes and prices)
$attributes = [
    // Redmi Note 11 variants
    ['product_id' => 1, 'size' => '64GB-4GB', 'price' => 12000.00, 'stock' => 100, 'sku' => 'RN11-64-4', 'status' => 1],
    ['product_id' => 1, 'size' => '128GB-4GB', 'price' => 14400.00, 'stock' => 100, 'sku' => 'RN11-128-4', 'status' => 1],
    ['product_id' => 1, 'size' => '128GB-6GB', 'price' => 16000.00, 'stock' => 100, 'sku' => 'RN11-128-6', 'status' => 1],

    // T-Shirt sizes
    ['product_id' => 2, 'size' => 'Small', 'price' => 1100.00, 'stock' => 100, 'sku' => 'RC001-S', 'status' => 1],
    ['product_id' => 2, 'size' => 'Medium', 'price' => 1200.00, 'stock' => 100, 'sku' => 'RC001-M', 'status' => 1],
    ['product_id' => 2, 'size' => 'Large', 'price' => 1300.00, 'stock' => 100, 'sku' => 'RC001-L', 'status' => 1],

    ['product_id' => 3, 'size' => 'Small', 'price' => 1100.00, 'stock' => 100, 'sku' => 'AT01-S', 'status' => 1],
    ['product_id' => 3, 'size' => 'Medium', 'price' => 1200.00, 'stock' => 100, 'sku' => 'AT01-M', 'status' => 1],
    ['product_id' => 3, 'size' => 'Large', 'price' => 1300.00, 'stock' => 100, 'sku' => 'AT01-L', 'status' => 1],

    ['product_id' => 4, 'size' => 'Small', 'price' => 1000.00, 'stock' => 100, 'sku' => 'BT01-S', 'status' => 1],
    ['product_id' => 4, 'size' => 'Medium', 'price' => 1100.00, 'stock' => 100, 'sku' => 'BT01-M', 'status' => 1],
    ['product_id' => 4, 'size' => 'Large', 'price' => 1200.00, 'stock' => 100, 'sku' => 'BT01-L', 'status' => 1],

    ['product_id' => 5, 'size' => 'Small', 'price' => 720.00, 'stock' => 100, 'sku' => 'GT01-S', 'status' => 1],
    ['product_id' => 5, 'size' => 'Medium', 'price' => 810.00, 'stock' => 100, 'sku' => 'GT01-M', 'status' => 1],
    ['product_id' => 5, 'size' => 'Large', 'price' => 900.00, 'stock' => 100, 'sku' => 'GT01-L', 'status' => 1],
];

foreach ($attributes as $attr) {
    $attr['created_at'] = now();
    $attr['updated_at'] = now();
    DB::table('products_attributes')->insert($attr);
}

echo "Inserted product attributes\n";

// Insert some product images
$images = [
    ['product_id' => 1, 'image' => '91540-1.jpg', 'status' => 1],
    ['product_id' => 1, 'image' => '91540-2.jpg', 'status' => 1],
    ['product_id' => 2, 'image' => '95575-1.jpg', 'status' => 1],
    ['product_id' => 2, 'image' => '95575-2.jpg', 'status' => 1],
    ['product_id' => 3, 'image' => '27416-1.jpg', 'status' => 1],
    ['product_id' => 4, 'image' => '58892-1.png', 'status' => 1],
    ['product_id' => 5, 'image' => '79204-1.png', 'status' => 1],
];

foreach ($images as $img) {
    $img['created_at'] = now();
    $img['updated_at'] = now();
    DB::table('products_images')->insert($img);
}

echo "Inserted product images\n";

// Re-enable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS=1');

// Now let's fix the orders_products table by inserting some order items
echo "Inserting order items...\n";

DB::table('orders_products')->truncate();

$orderItems = [
    [
        'order_id'        => 1,
        'user_id'         => 2,
        'vendor_id'       => 0,
        'admin_id'        => 1,
        'product_id'      => 1,
        'product_code'    => 'RN11',
        'product_name'    => 'Redmi Note 11',
        'product_color'   => 'Blue',
        'product_size'    => '128GB-4GB',
        'product_price'   => 14400.00,
        'product_qty'     => 1,
        'courier_name'    => null,
        'tracking_number' => null,
        'item_status'     => 'New',
        'created_at'      => now(),
        'updated_at'      => now(),
    ],
    [
        'order_id'        => 2,
        'user_id'         => 2,
        'vendor_id'       => 0,
        'admin_id'        => 1,
        'product_id'      => 2,
        'product_code'    => 'RC001',
        'product_name'    => 'Red Casual T-Shirt',
        'product_color'   => 'Red',
        'product_size'    => 'Medium',
        'product_price'   => 1200.00,
        'product_qty'     => 2,
        'courier_name'    => null,
        'tracking_number' => null,
        'item_status'     => 'New',
        'created_at'      => now(),
        'updated_at'      => now(),
    ],
];

foreach ($orderItems as $item) {
    DB::table('orders_products')->insert($item);
    echo "Inserted order item: {$item['product_name']}\n";
}

echo "\nData insertion completed!\n";

// Final verification
echo "\nFinal verification:\n";
$tables = ['products', 'products_attributes', 'products_images', 'orders_products'];

foreach ($tables as $table) {
    $count = DB::table($table)->count();
    echo "- $table: $count records\n";
}

echo "\nDemo data insertion successful!\n";
