<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->tinyInteger('role')->default(4);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();


            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();


            $table->enum('tipo', ['MINORISTA','MAYORISTA'])->default('MINORISTA');
            $table->decimal('saldo', 15, 4)->default(0);

            $table->string('cuit')->nullable();
            $table->string('direccion_fact')->nullable();
            $table->string('coments_client', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
