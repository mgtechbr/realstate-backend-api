<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
	{
		Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->decimal('price', 10, 2);
            $table->text('description'); 
            $table->string('bathroom', 50); 
            $table->integer('bedroom'); 
            $table->decimal('area', 10, 2); 
            $table->enum('type', ['casa', 'apartamento', 'terreno']);

			$table->unsignedBigInteger('city_id'); // ID da cidade
			$table->unsignedBigInteger('state_id'); // ID do estado
			$table->unsignedBigInteger('district_id'); // ID do bairro
		
			// Definindo as chaves estrangeiras
			$table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
			$table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
			$table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
			$table->string('image')->nullable();
            $table->timestamps();
        });
	}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
