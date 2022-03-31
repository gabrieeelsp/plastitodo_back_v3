<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ModelofactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modelofacts')->insert([
            'name' => "A",
        ]);
        DB::table('modelofacts')->insert([
            'name' => "B",
            'monto_max_no_id_efectivo' => 17000,
            'monto_max_no_id_electronico' => 31000,
        ]);
        DB::table('modelofacts')->insert([
            'name' => "TIQUE",
            'monto_max_no_id_efectivo' => 17000,
            'monto_max_no_id_electronico' => 31000,
            'monto_max' => 31000
        ]);
    }
}
