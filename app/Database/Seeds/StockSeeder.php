<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('categories')->insertBatch([
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and accessories',
                'created_at' => $now,
            ],
            [
                'name' => 'Furniture',
                'description' => 'Home and office furniture',
                'created_at' => $now,
            ],
            [
                'name' => 'Kitchen',
                'description' => 'Kitchen tools and appliances',
                'created_at' => $now,
            ],
            [
                'name' => 'Office Supplies',
                'description' => 'Products used in offices and workspaces',
                'created_at' => $now,
            ],
            [
                'name' => 'Sports',
                'description' => 'Sports equipment and accessories',
                'created_at' => $now,
            ],
        ]);

        $this->db->table('suppliers')->insertBatch([
            [
                'company_name' => 'Tech Supplier',
                'email' => 'contact@techsupplier.com',
                'phone' => '+33123456789',
                'country' => 'France',
                'created_at' => $now,
            ],
            [
                'company_name' => 'Home Distribution',
                'email' => 'sales@homedistribution.com',
                'phone' => '+33456789123',
                'country' => 'France',
                'created_at' => $now,
            ],
            [
                'company_name' => 'Office Pro',
                'email' => 'hello@officepro.com',
                'phone' => '+33199887766',
                'country' => 'Belgium',
                'created_at' => $now,
            ],
            [
                'company_name' => 'Global Sports Supply',
                'email' => 'contact@globalsports.com',
                'phone' => '+34987654321',
                'country' => 'Spain',
                'created_at' => $now,
            ],
        ]);

        $this->db->table('products')->insertBatch([
            [
                'name' => 'Gaming Mouse',
                'sku' => 'MOUSE-001',
                'weight' => 1200,
                'price' => 39.99,
                'stock_quantity' => 8,
                'category_id' => 1,
                'supplier_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'sku' => 'KEYBOARD-001',
                'weight' => 1100,
                'price' => 79.99,
                'stock_quantity' => 12,
                'category_id' => 1,
                'supplier_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'USB-C Cable',
                'sku' => 'CABLE-001',
                'weight' => 100,
                'price' => 9.99,
                'stock_quantity' => 50,
                'category_id' => 1,
                'supplier_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Office Chair',
                'sku' => 'CHAIR-001',
                'weight' => 7000,
                'price' => 89.99,
                'stock_quantity' => 15,
                'category_id' => 2,
                'supplier_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Wooden Desk',
                'sku' => 'DESK-001',
                'weight' => 25000,
                'price' => 149.99,
                'stock_quantity' => 6,
                'category_id' => 2,
                'supplier_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Electric Kettle',
                'sku' => 'KETTLE-001',
                'weight' => 900,
                'price' => 29.99,
                'stock_quantity' => 5,
                'category_id' => 3,
                'supplier_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Coffee Machine',
                'sku' => 'COFFEE-001',
                'weight' => 1800,
                'price' => 45.99,
                'stock_quantity' => 4,
                'category_id' => 3,
                'supplier_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Notebook Pack',
                'sku' => 'NOTEBOOK-001',
                'weight' => 600,
                'price' => 12.99,
                'stock_quantity' => 30,
                'category_id' => 4,
                'supplier_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Printer Paper Box',
                'sku' => 'PAPER-001',
                'weight' => 2500,
                'price' => 19.99,
                'stock_quantity' => 9,
                'category_id' => 4,
                'supplier_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Yoga Mat',
                'sku' => 'YOGA-001',
                'weight' => 1300,
                'price' => 24.99,
                'stock_quantity' => 20,
                'category_id' => 5,
                'supplier_id' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Football',
                'sku' => 'FOOTBALL-001',
                'weight' => 450,
                'price' => 19.99,
                'stock_quantity' => 7,
                'category_id' => 5,
                'supplier_id' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
