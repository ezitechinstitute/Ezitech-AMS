<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('construction_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('district')->nullable();
            $table->string('tehsil')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('intiqal_number')->nullable();
            $table->date('intiqal_date')->nullable();
            $table->string('total_area')->nullable();
            $table->string('total_area_unit')->nullable();
            $table->text('description')->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('construction_projects');
    }
};
