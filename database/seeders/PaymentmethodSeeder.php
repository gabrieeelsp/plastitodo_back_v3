<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class PaymentmethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paymentmethods')->insert([
            'name' => "Efectivo",
            'is_enable' => 1,
        ]);

        DB::table('paymentmethods')->insert([
            'name' => "Visa Débito",
            'is_enable' => 1,
        ]);

        DB::table('paymentmethods')->insert([
            'name' => "Visa Crédito",
            'is_enable' => 1,
        ]);

        DB::table('paymentmethods')->insert([
            'name' => "Maestro Débito",
            'is_enable' => 1,
        ]);

        DB::table('paymentmethods')->insert([
            'name' => "Transferencia",
            'is_enable' => 1,
        ]);

        DB::table('paymentmethods')->insert([
            'name' => "QR",
            'is_enable' => 1,
        ]);
    }
}
