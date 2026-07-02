<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mouzas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('district')->nullable();
            $table->string('tehsil')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();   // Google Maps
            $table->decimal('longitude', 10, 7)->nullable();  // Google Maps
            $table->text('description')->nullable();
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mouzas');
    }
};
