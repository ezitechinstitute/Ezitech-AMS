<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('real_estate_fields', function (Blueprint $table) {
            // Breakdown of the land area (Pakistani revenue units).
            // area_quantity (existing column) will store the normalized TOTAL in Marla.
            $table->decimal('area_acre', 10, 2)->default(0)->after('area_unit');
            $table->decimal('area_kanal', 10, 2)->default(0)->after('area_acre');
            $table->decimal('area_marla', 10, 2)->default(0)->after('area_kanal');
        });
    }

    public function down(): void
    {
        Schema::table('real_estate_fields', function (Blueprint $table) {
            $table->dropColumn(['area_acre', 'area_kanal', 'area_marla']);
        });
    }
};
