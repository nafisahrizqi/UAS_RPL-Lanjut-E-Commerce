<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;
use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Seed Staff Users
        $users = [
            [
                'name' => 'Manajer',
                'username' => 'manajer',
                'password' => Hash::make('admin'),
                'role' => 'manager',
                'phone' => '0821',
                'joined_at' => Carbon::now()->subDay(),
            ],
            [
                'name' => 'Teller',
                'username' => 'teller',
                'password' => Hash::make('admin'),
                'role' => 'teller',
                'phone' => '0822',
                'joined_at' => Carbon::now(),
            ],
            [
                'name' => 'Collector',
                'username' => 'kolektor',
                'password' => Hash::make('admin'),
                'role' => 'collector',
                'phone' => '0823',
                'joined_at' => Carbon::now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // 2. Seed Customers (Nasabah)
        $budi = Customer::create([
            'nik' => '1234567890123456',
            'name' => 'Budi Santoso',
            'number' => 'CUST-001',
            'gender' => 'L',
            'birth' => '1990-05-15',
            'address' => 'Jl. Pemuda No. 12, Jepara',
            'phone' => '08123456789',
            'last_education' => 'SMA',
            'profession' => 'Wiraswasta',
            'status' => 'active',
            'joined_at' => Carbon::now()->subMonths(6),
            'username' => 'budi',
            'password' => Hash::make('user'),
            'email' => 'budi@gmail.com',
        ]);

        $siti = Customer::create([
            'nik' => '1234567890123457',
            'name' => 'Siti Aminah',
            'number' => 'CUST-002',
            'gender' => 'P',
            'birth' => '1995-08-20',
            'address' => 'Jl. Kartini No. 45, Jepara',
            'phone' => '08123456790',
            'last_education' => 'D3',
            'profession' => 'Pegawai Swasta',
            'status' => 'active',
            'joined_at' => Carbon::now()->subMonths(3),
            'username' => 'siti',
            'password' => Hash::make('user'),
            'email' => 'siti@gmail.com',
        ]);

        // 3. Seed Deposits (Simpanan Awal) for Budi
        Deposit::create([
            'type' => 'pokok',
            'amount' => 100000,
            'previous_balance' => 0,
            'current_balance' => 100000,
            'customer_id' => $budi->id,
            'created_at' => Carbon::now()->subMonths(6),
        ]);

        Deposit::create([
            'type' => 'wajib',
            'amount' => 50000,
            'previous_balance' => 100000,
            'current_balance' => 150000,
            'customer_id' => $budi->id,
            'created_at' => Carbon::now()->subMonths(5),
        ]);

        // Simpanan Sukarela Budi sebesar Rp 1.000.000 (untuk belanja E-Commerce)
        Deposit::create([
            'type' => 'sukarela',
            'amount' => 1000000,
            'previous_balance' => 150000,
            'current_balance' => 1150000,
            'customer_id' => $budi->id,
            'created_at' => Carbon::now()->subMonths(4),
        ]);

        // 4. Seed E-Commerce Categories
        $sembako = Category::create([
            'name' => 'Sembako',
            'slug' => 'sembako',
        ]);

        $makanan = Category::create([
            'name' => 'Makanan & Minuman',
            'slug' => 'makanan-dan-minuman',
        ]);

        // 5. Seed E-Commerce Products
        Product::create([
            'category_id' => $sembako->id,
            'name' => 'Beras Premium 5kg',
            'slug' => 'beras-premium-5kg',
            'price' => 65000,
            'stock' => 50,
            'description' => 'Beras premium kualitas super mentik wangi pulen alami.',
            'image' => '1.jpg',
        ]);

        Product::create([
            'category_id' => $sembako->id,
            'name' => 'Minyak Goreng 2L',
            'slug' => 'minyak-goreng-2l',
            'price' => 34000,
            'stock' => 40,
            'description' => 'Minyak goreng kelapa sawit berkualitas tinggi jernih.',
            'image' => '2.jpg',
        ]);

        Product::create([
            'category_id' => $sembako->id,
            'name' => 'Gula Pasir 1kg',
            'slug' => 'gula-pasir-1kg',
            'price' => 15000,
            'stock' => 100,
            'description' => 'Gula pasir putih manis murni tebu asli pilihan.',
            'image' => '3.jpg',
        ]);

        Product::create([
            'category_id' => $makanan->id,
            'name' => 'Kopi Bubuk Murni 250g',
            'slug' => 'kopi-bubuk-murni-250g',
            'price' => 12000,
            'stock' => 75,
            'description' => 'Kopi robusta asli khas Jepara digiling dengan tingkat kematangan sempurna.',
            'image' => '4.jpg',
        ]);

        Product::create([
            'category_id' => $makanan->id,
            'name' => 'Teh Celup Melati (Isi 25)',
            'slug' => 'teh-celup-melati-isi-25',
            'price' => 6000,
            'stock' => 150,
            'description' => 'Teh celup wangi melati alami yang memberikan rasa rileks.',
            'image' => '5.jpg',
        ]);

        // 6. Seed Collateral for Siti Aminah
        $collateral = \App\Models\Collateral::create([
            'name' => 'BPKB Motor Honda Beat 2020',
            'value' => 12000000,
            'description' => 'Kondisi mulus, surat lengkap atas nama Siti Aminah.',
            'customer_id' => $siti->id,
        ]);

        // 7. Seed Loan for Siti Aminah
        $loan = \App\Models\Loan::create([
            'period' => 12,
            'amount' => 5000000,
            'installment' => 500000,
            'return_amount' => 6000000,
            'customer_id' => $siti->id,
            'collateral_id' => $collateral->id,
            'created_at' => Carbon::now()->subMonths(3),
        ]);

        // 8. Seed Visit Record by Collector (kolektor) for Siti Aminah's Loan
        $collector = User::where('role', 'collector')->first();
        \App\Models\Visit::create([
            'remaining_amount' => 4500000,
            'description' => 'Nasabah sulit ditemui di rumah. Berjanji akan melakukan cicilan minggu depan.',
            'loan_id' => $loan->id,
            'customer_id' => $siti->id,
            'user_id' => $collector->id,
            'created_at' => Carbon::now()->subDays(5),
        ]);
    }
}
