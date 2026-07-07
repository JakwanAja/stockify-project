<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // ===== KATEGORI =====
        DB::table('categories')->insert([
            ['name' => 'Elektronik', 'description' => 'Perangkat elektronik dan gadget', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pakaian', 'description' => 'Pakaian pria, wanita, dan anak', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Makanan & Minuman', 'description' => 'Produk konsumsi sehari-hari', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Alat Tulis', 'description' => 'Perlengkapan kantor dan sekolah', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Perabot Rumah', 'description' => 'Furnitur dan dekorasi rumah', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kesehatan', 'description' => 'Produk kesehatan dan kebersihan', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ===== SUPPLIER =====
        DB::table('suppliers')->insert([
            [
                'name'       => 'PT. Teknologi Maju',
                'email'      => 'order@teknologimaju.co.id',
                'phone'      => '02112345678',
                'address'    => 'Jl. Sudirman No. 12, Jakarta Pusat',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name'       => 'CV. Sandang Nusantara',
                'email'      => 'info@sandangnusantara.com',
                'phone'      => '02298765432',
                'address'    => 'Jl. Pahlawan No. 45, Bandung',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name'       => 'PT. Pangan Sejahtera',
                'email'      => 'supply@pangansejahtera.id',
                'phone'      => '03187654321',
                'address'    => 'Jl. Gajah Mada No. 88, Surabaya',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name'       => 'UD. Stationery Indah',
                'email'      => 'sales@stationeryindah.com',
                'phone'      => '02456781234',
                'address'    => 'Jl. Malioboro No. 7, Yogyakarta',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name'       => 'PT. Griya Furniture',
                'email'      => 'order@griyafurniture.co.id',
                'phone'      => '02134567890',
                'address'    => 'Jl. Ahmad Yani No. 33, Semarang',
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        // Ambil ID kategori dan supplier
        $elektronik  = DB::table('categories')->where('name', 'Elektronik')->value('id');
        $pakaian     = DB::table('categories')->where('name', 'Pakaian')->value('id');
        $makanan     = DB::table('categories')->where('name', 'Makanan & Minuman')->value('id');
        $alatTulis   = DB::table('categories')->where('name', 'Alat Tulis')->value('id');
        $perabot     = DB::table('categories')->where('name', 'Perabot Rumah')->value('id');
        $kesehatan   = DB::table('categories')->where('name', 'Kesehatan')->value('id');

        $supTeknologi  = DB::table('suppliers')->where('name', 'PT. Teknologi Maju')->value('id');
        $supSandang    = DB::table('suppliers')->where('name', 'CV. Sandang Nusantara')->value('id');
        $supPangan     = DB::table('suppliers')->where('name', 'PT. Pangan Sejahtera')->value('id');
        $supStationery = DB::table('suppliers')->where('name', 'UD. Stationery Indah')->value('id');
        $supFurniture  = DB::table('suppliers')->where('name', 'PT. Griya Furniture')->value('id');

        // ===== PRODUK =====
        DB::table('products')->insert([
            // Elektronik
            [
                'category_id'    => $elektronik,
                'supplier_id'    => $supTeknologi,
                'name'           => 'Laptop ASUS VivoBook 14',
                'sku'            => 'ELK-ASUS-001',
                'description'    => 'Laptop ringan dengan prosesor Intel Core i5 generasi 12, RAM 8GB, SSD 512GB',
                'purchase_price' => 7500000,
                'selling_price'  => 8499000,
                'minimum_stock'  => 5,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],
            [
                'category_id'    => $elektronik,
                'supplier_id'    => $supTeknologi,
                'name'           => 'Samsung Galaxy A54',
                'sku'            => 'ELK-SAM-001',
                'description'    => 'Smartphone Android dengan layar Super AMOLED 6.4 inci, kamera 50MP',
                'purchase_price' => 4200000,
                'selling_price'  => 4999000,
                'minimum_stock'  => 10,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],
            [
                'category_id'    => $elektronik,
                'supplier_id'    => $supTeknologi,
                'name'           => 'Headphone Sony WH-1000XM4',
                'sku'            => 'ELK-SNY-001',
                'description'    => 'Headphone noise-cancelling premium dengan baterai 30 jam',
                'purchase_price' => 2800000,
                'selling_price'  => 3299000,
                'minimum_stock'  => 8,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],
            [
                'category_id'    => $elektronik,
                'supplier_id'    => $supTeknologi,
                'name'           => 'Keyboard Mechanical Logitech G413',
                'sku'            => 'ELK-LOG-001',
                'description'    => 'Keyboard gaming mechanical dengan switch Romer-G tactile',
                'purchase_price' => 850000,
                'selling_price'  => 999000,
                'minimum_stock'  => 15,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],

            // Pakaian
            [
                'category_id'    => $pakaian,
                'supplier_id'    => $supSandang,
                'name'           => 'Kemeja Pria Formal Putih',
                'sku'            => 'PKN-KMP-001',
                'description'    => 'Kemeja formal bahan katun premium, tersedia ukuran S-XXL',
                'purchase_price' => 85000,
                'selling_price'  => 135000,
                'minimum_stock'  => 20,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],
            [
                'category_id'    => $pakaian,
                'supplier_id'    => $supSandang,
                'name'           => 'Kaos Polos Cotton Combed 30s',
                'sku'            => 'PKN-KPS-001',
                'description'    => 'Kaos polos bahan cotton combed 30s, berbagai warna tersedia',
                'purchase_price' => 35000,
                'selling_price'  => 65000,
                'minimum_stock'  => 50,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],
            [
                'category_id'    => $pakaian,
                'supplier_id'    => $supSandang,
                'name'           => 'Celana Chino Pria',
                'sku'            => 'PKN-CCP-001',
                'description'    => 'Celana chino casual bahan stretch, warna navy dan khaki',
                'purchase_price' => 120000,
                'selling_price'  => 189000,
                'minimum_stock'  => 15,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],

            // Makanan & Minuman
            [
                'category_id'    => $makanan,
                'supplier_id'    => $supPangan,
                'name'           => 'Mie Instan Goreng Spesial',
                'sku'            => 'MKN-MIG-001',
                'description'    => 'Mie instan goreng rasa ayam pedas, per karton isi 40 bungkus',
                'purchase_price' => 85000,
                'selling_price'  => 105000,
                'minimum_stock'  => 30,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],
            [
                'category_id'    => $makanan,
                'supplier_id'    => $supPangan,
                'name'           => 'Air Mineral 600ml',
                'sku'            => 'MKN-AMN-001',
                'description'    => 'Air mineral murni dalam kemasan botol 600ml, per dus 24 botol',
                'purchase_price' => 28000,
                'selling_price'  => 40000,
                'minimum_stock'  => 50,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],

            // Alat Tulis
            [
                'category_id'    => $alatTulis,
                'supplier_id'    => $supStationery,
                'name'           => 'Pulpen Ballpoint Pilot G2',
                'sku'            => 'ALT-PBP-001',
                'description'    => 'Pulpen gel premium dengan tinta biru, per box isi 12 pcs',
                'purchase_price' => 48000,
                'selling_price'  => 72000,
                'minimum_stock'  => 25,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],
            [
                'category_id'    => $alatTulis,
                'supplier_id'    => $supStationery,
                'name'           => 'Buku Tulis A5 96 Lembar',
                'sku'            => 'ALT-BTA-001',
                'description'    => 'Buku tulis bergaris ukuran A5, kertas HVS 70gsm',
                'purchase_price' => 8500,
                'selling_price'  => 14000,
                'minimum_stock'  => 100,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],
            [
                'category_id'    => $alatTulis,
                'supplier_id'    => $supStationery,
                'name'           => 'Spidol Whiteboard Snowman',
                'sku'            => 'ALT-SWB-001',
                'description'    => 'Spidol whiteboard hitam, per box isi 12 pcs',
                'purchase_price' => 36000,
                'selling_price'  => 55000,
                'minimum_stock'  => 20,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],

            // Perabot Rumah
            [
                'category_id'    => $perabot,
                'supplier_id'    => $supFurniture,
                'name'           => 'Kursi Kerja Ergonomis',
                'sku'            => 'PRB-KKE-001',
                'description'    => 'Kursi kerja dengan sandaran punggung adjustable dan bantalan busa',
                'purchase_price' => 850000,
                'selling_price'  => 1199000,
                'minimum_stock'  => 5,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],
            [
                'category_id'    => $perabot,
                'supplier_id'    => $supFurniture,
                'name'           => 'Meja Kerja Minimalis',
                'sku'            => 'PRB-MKM-001',
                'description'    => 'Meja kerja desain minimalis 120x60cm, material kayu MDF',
                'purchase_price' => 650000,
                'selling_price'  => 899000,
                'minimum_stock'  => 3,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],

            // Kesehatan
            [
                'category_id'    => $kesehatan,
                'supplier_id'    => $supPangan,
                'name'           => 'Masker Medis 3 Ply',
                'sku'            => 'KSH-MSK-001',
                'description'    => 'Masker medis sekali pakai 3 lapis, per box isi 50 pcs',
                'purchase_price' => 25000,
                'selling_price'  => 38000,
                'minimum_stock'  => 40,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],
            [
                'category_id'    => $kesehatan,
                'supplier_id'    => $supPangan,
                'name'           => 'Hand Sanitizer 500ml',
                'sku'            => 'KSH-HDS-001',
                'description'    => 'Hand sanitizer berbasis alkohol 70%, cocok untuk penggunaan kantor',
                'purchase_price' => 32000,
                'selling_price'  => 48000,
                'minimum_stock'  => 25,
                'image'          => null,
                'created_at'     => now(), 'updated_at' => now(),
            ],
        ]);

        // ===== PRODUCT ATTRIBUTES =====
        $laptop  = DB::table('products')->where('sku', 'ELK-ASUS-001')->value('id');
        $samsung = DB::table('products')->where('sku', 'ELK-SAM-001')->value('id');
        $kemeja  = DB::table('products')->where('sku', 'PKN-KMP-001')->value('id');
        $kaos    = DB::table('products')->where('sku', 'PKN-KPS-001')->value('id');
        $kursi   = DB::table('products')->where('sku', 'PRB-KKE-001')->value('id');

        DB::table('product_attributes')->insert([
            // Laptop
            ['product_id' => $laptop, 'name' => 'Prosesor', 'value' => 'Intel Core i5-1235U'],
            ['product_id' => $laptop, 'name' => 'RAM', 'value' => '8GB DDR4'],
            ['product_id' => $laptop, 'name' => 'Storage', 'value' => 'SSD 512GB NVMe'],
            ['product_id' => $laptop, 'name' => 'Layar', 'value' => '14 inci FHD IPS'],
            ['product_id' => $laptop, 'name' => 'OS', 'value' => 'Windows 11 Home'],

            // Samsung
            ['product_id' => $samsung, 'name' => 'Layar', 'value' => '6.4 inci Super AMOLED'],
            ['product_id' => $samsung, 'name' => 'RAM', 'value' => '6GB'],
            ['product_id' => $samsung, 'name' => 'Storage', 'value' => '128GB'],
            ['product_id' => $samsung, 'name' => 'Kamera', 'value' => '50MP + 12MP + 5MP'],
            ['product_id' => $samsung, 'name' => 'Baterai', 'value' => '5000mAh'],

            // Kemeja
            ['product_id' => $kemeja, 'name' => 'Bahan', 'value' => 'Katun Premium 100%'],
            ['product_id' => $kemeja, 'name' => 'Ukuran', 'value' => 'S, M, L, XL, XXL'],
            ['product_id' => $kemeja, 'name' => 'Warna', 'value' => 'Putih'],

            // Kaos
            ['product_id' => $kaos, 'name' => 'Bahan', 'value' => 'Cotton Combed 30s'],
            ['product_id' => $kaos, 'name' => 'Ukuran', 'value' => 'S, M, L, XL'],
            ['product_id' => $kaos, 'name' => 'Warna', 'value' => 'Hitam, Putih, Navy, Abu'],

            // Kursi
            ['product_id' => $kursi, 'name' => 'Material', 'value' => 'Mesh & Busa Density'],
            ['product_id' => $kursi, 'name' => 'Tinggi Adjustable', 'value' => '43-53 cm'],
            ['product_id' => $kursi, 'name' => 'Kapasitas Berat', 'value' => 'Maks. 120kg'],
            ['product_id' => $kursi, 'name' => 'Warna', 'value' => 'Hitam'],
        ]);
    }
}