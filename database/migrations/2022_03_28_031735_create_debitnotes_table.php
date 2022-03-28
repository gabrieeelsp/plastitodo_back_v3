<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitnotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debitnotes', function (Blueprint $table) {
            $table->id();
            
            $table->timestamps();

            $table->string('description', 200)->nullable();

            $table->decimal('valor', 15, 4)->default(0);

            $table->decimal('saldo', 15, 4)->default(0);

            $table->foreignId('sale_id')->nullable()->constrained('sales')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sucursal_id')->nullable()->constrained('sucursals')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debitnotes');
    }
}
