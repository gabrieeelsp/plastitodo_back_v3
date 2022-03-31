<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelofactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelofacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('monto_max_no_id_efectivo')->nullable();
            $table->decimal('monto_max_no_id_electronico')->nullable();
            $table->decimal('monto_max')->nullable();

            $table->boolean('is_enable')->default(true);
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modelofacts');
    }
}
