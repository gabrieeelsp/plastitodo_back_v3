<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class IvaconditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ivaconditions')->insert([
            'name' => "Responsable Inscripto",
        ]);

        $respInscripto = \App\Models\Ivacondition::find(1);
        $respInscripto->modelofacts()->attach(1);

        DB::table('ivaconditions')->insert([
            'name' => "Monotributo",
        ]);

        $monotributo = \App\Models\Ivacondition::find(2);
        $monotributo->modelofacts()->attach(1);

        DB::table('ivaconditions')->insert([
            'name' => "Consumidor Final",
        ]);

        $consFinal = \App\Models\Ivacondition::find(3);
        $consFinal->modelofacts()->attach(2);
        $consFinal->modelofacts()->attach(3);
    }
}
