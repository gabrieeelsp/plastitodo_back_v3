<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockproducts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('costo', 15, 4)->default(0);

            $table->boolean('is_stock_unitario_kilo')->default(false);
            $table->decimal('stock_aproximado_unidad', 15, 4)->default(0);

            $table->foreignId('iva_id')->constrained('ivas')->onUpdate('cascade')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stockproducts');
    }
}
