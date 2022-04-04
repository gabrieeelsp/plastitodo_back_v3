<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IvaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ivas')->insert([
            'name' => '21,00',
            'valor' => 21,
            'codigo_afip' => '5'
        ]);
        
        DB::table('ivas')->insert([
            'name' => '10,50',
            'valor' => 10.5,
            'codigo_afip' => '4'
        ]);

        
    }
}
