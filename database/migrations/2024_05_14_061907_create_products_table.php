<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      
        Schema::create('products', function (Blueprint $table) {
            $table->id('p_id');
            $table->string('name');
            $table->string('images'); 
            $table->integer('price');
            $table->integer('quantity'); // Adding quantity column
          //  $table->c_id('c_id');
            $table->unsignedBigInteger('c_id'); // Assuming c_id is a foreign key
            $table->foreign('c_id')->references('c_id')->on('categeroy')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
