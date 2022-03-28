<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use App\Models\Sucursal;

class StockproductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stockproducts')->insert([
            'name' => "Cacao Amargo 1,00Kg ALPINO",
            'costo' => 100
        ]);
        foreach(Sucursal::all() as $sucursal){
            DB::table('stocksucursals')->insert([
                'stockproduct_id' => 1,
                'sucursal_id' => $sucursal->id
            ]);
        }

        DB::table('saleproducts')->insert([
            'stockproduct_id' => 1,
            'name' => 'Cacao Amargo 1,00Kg ALPINO UNIDAD',
            'relacion_venta_stock' => 1,
            'porc_min' => 20,
            'porc_may' => 15
        ]);
        DB::table('saleproducts')->insert([
            'stockproduct_id' => 1,
            'name' => 'Cacao Amargo 1,00Kg ALPINO BULTO x5',
            'relacion_venta_stock' => 5
        ]);
#--------------------------------------------------- 2
        DB::table('stockproducts')->insert([
            'name' => "Cacao Amargo 0,10Kg ALPINO",
            'costo' => 10
        ]);
        foreach(Sucursal::all() as $sucursal){
            DB::table('stocksucursals')->insert([
                'stockproduct_id' => 2,
                'sucursal_id' => $sucursal->id
            ]);
        }

        DB::table('saleproducts')->insert([
            'stockproduct_id' => 2,
            'name' => 'Cacao Amargo 0,10Kg ALPINO UNIDAD',
            'relacion_venta_stock' => 1,
            'porc_min' => 100,
            'porc_may' => 50
        ]);
        DB::table('saleproducts')->insert([
            'stockproduct_id' => 2,
            'name' => 'Cacao Amargo 0,10Kg ALPINO BULTO x10',
            'relacion_venta_stock' => 10,
            'porc_min' => 50,
            'porc_may' => 35
        ]);
#--------------------------------------------------- 3

        DB::table('stockproducts')->insert([
            'name' => "Bandeja de Carton Nro 1 GRIS UNIDAD",
            'costo' => 3.6
        ]);
        foreach(Sucursal::all() as $sucursal){
            DB::table('stocksucursals')->insert([
                'stockproduct_id' => 3,
                'sucursal_id' => $sucursal->id
            ]);
        }

        DB::table('saleproducts')->insert([
            'stockproduct_id' => 3,
            'name' => 'Bandeja de Carton Nro 1 GRIS UNIDAD',
            'relacion_venta_stock' => 1,
            'porc_min' => 60,
            'porc_may' => 40
        ]);
        DB::table('saleproducts')->insert([
            'stockproduct_id' => 3,
            'name' => 'Bandeja de Carton Nro 1 GRIS PQ x 100',
            'relacion_venta_stock' => 100,
            'porc_min' => 35,
            'porc_may' => 15
        ]);
        DB::table('saleproducts')->insert([
            'stockproduct_id' => 3,
            'name' => 'Bandeja de Carton Nro 1 GRIS BULTO x 800',
            'relacion_venta_stock' => 800,
            'porc_min' => 16,
            'porc_may' => 15
        ]);
#--------------------------------------------------- 4
        DB::table('stockproducts')->insert([
            'name' => "Bandeja de Carton Nro 2 GRIS UNIDAD",
            'costo' => 4.3
        ]);
        foreach(Sucursal::all() as $sucursal){
            DB::table('stocksucursals')->insert([
                'stockproduct_id' => 4,
                'sucursal_id' => $sucursal->id
            ]);
        }

        DB::table('saleproducts')->insert([
            'stockproduct_id' => 4,
            'name' => 'Bandeja de Carton Nro 2 GRIS UNIDAD',
            'relacion_venta_stock' => 1,
            'porc_min' => 80,
            'porc_may' => 60
        ]);
        DB::table('saleproducts')->insert([
            'stockproduct_id' => 4,
            'name' => 'Bandeja de Carton Nro 2 GRIS PQ x 100',
            'relacion_venta_stock' => 100,
            'porc_min' => 35,
            'porc_may' => 15
        ]);
        DB::table('saleproducts')->insert([
            'stockproduct_id' => 4,
            'name' => 'Bandeja de Carton Nro 2 GRIS BULTO x 800',
            'relacion_venta_stock' => 800,
            'porc_min' => 16,
            'porc_may' => 15
        ]);
#--------------------------------------------------- 5
        DB::table('stockproducts')->insert([
            'name' => "Bandeja de Carton Nro 3 GRIS UNIDAD",
            'costo' => 5.6
        ]);
        foreach(Sucursal::all() as $sucursal){
            DB::table('stocksucursals')->insert([
                'stockproduct_id' => 5,
                'sucursal_id' => $sucursal->id
            ]);
        }

        DB::table('saleproducts')->insert([
            'stockproduct_id' => 5,
            'name' => 'Bandeja de Carton Nro 3 GRIS UNIDAD',
            'relacion_venta_stock' => 1,
            'porc_min' => 80,
            'porc_may' => 60
        ]);
        DB::table('saleproducts')->insert([
            'stockproduct_id' => 5,
            'name' => 'Bandeja de Carton Nro 3 GRIS PQ x 100',
            'relacion_venta_stock' => 100,
            'porc_min' => 35,
            'porc_may' => 15
        ]);
        DB::table('saleproducts')->insert([
            'stockproduct_id' => 5,
            'name' => 'Bandeja de Carton Nro 3 GRIS BULTO x 800',
            'relacion_venta_stock' => 800,
            'porc_min' => 16,
            'porc_may' => 15
        ]);
    #--------------------------------------------------- 6

        DB::table('stockproducts')->insert([
            'name' => "Papel Prensa en Bobina 40 cm",
            'costo' => 180,
            'is_stock_unitario_kilo' => true,
            'stock_aproximado_unidad' => 6
        ]);
        foreach(Sucursal::all() as $sucursal){
            DB::table('stocksucursals')->insert([
                'stockproduct_id' => 6,
                'sucursal_id' => $sucursal->id
            ]);
        }

        DB::table('saleproducts')->insert([
            'stockproduct_id' => 6,
            'name' => 'Papel Prensa en Bobina 40 cm xKG',
            'relacion_venta_stock' => 1,
            'porc_min' => 60,
            'porc_may' => 40
        ]);
    }
}
