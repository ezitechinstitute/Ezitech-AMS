<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kiwats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mouza_id');
            $table->string('kiwat_number'); // Block/Phase identifier, e.g. "Kiwat 1", "Phase A"
            $table->text('description')->nullable();
            $table->string('total_area')->nullable();
            $table->string('total_area_unit')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('mouza_id')->references('id')->on('mouzas')->onDelete('cascade');

            // Same Kiwat number should not repeat inside the same Mouza
            $table->unique(['mouza_id', 'kiwat_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kiwats');
    }
};
