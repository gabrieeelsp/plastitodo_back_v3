<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'gabriel',
            'surname' => 'picco',
            'email' => 'test@mail.com',
            'password' => bcrypt('secret999'),

            'role' => 4,
            'ivacondition_id' => 1,
            'modelofact_id' => 1,
            'tipo_id' => 'CUIT',
            'numero_id' => '20458967939',
            'fact_default' => true,

            'tipo' => 'MINORISTA',
        ]);
        DB::table('users')->insert([
            'name' => 'carolina',
            'surname' => 'saavedra',
            'email' => 'caro@mail.com',
            'password' => bcrypt('secret999'),

            'role' => 0,
            'ivacondition_id' => 3,
            'modelofact_id' => 3,
            'fact_default' => false,

            'tipo' => 'MINORISTA',
        ]);

        DB::table('users')->insert([
            'name' => 'Aquiles',
            'surname' => 'Taborelli',
            'email' => 'aquiles@mail.com',
            'password' => bcrypt('secret999'),

            'role' => 0,

            'tipo' => 'MAYORISTA',
        ]);

        DB::table('users')->insert([
            'name' => 'cotillon ',
            'surname' => 'perez',
            'email' => 'perez@mail.com',
            'password' => bcrypt('secret999'),

            'role' => 0,

            'tipo' => 'MINORISTA',
        ]);
    }
}
