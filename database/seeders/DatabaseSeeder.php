<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(SucursalSeeder::class);

        $this->call(StockproductSeeder::class);

        $this->call(PaymentmethodSeeder::class);

    }
}
