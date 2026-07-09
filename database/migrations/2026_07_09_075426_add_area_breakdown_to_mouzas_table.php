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
    public function up(): void
    {
        Schema::table('mouzas', function (Blueprint $table) {
            $table->decimal('area_acre', 10, 2)->default(0)->after('total_area_unit');
            $table->decimal('area_kanal', 10, 2)->default(0)->after('area_acre');
            $table->decimal('area_marla', 10, 2)->default(0)->after('area_kanal');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('mouzas', function (Blueprint $table) {
            $table->dropColumn(['area_acre', 'area_kanal', 'area_marla']);
        });
    }
};
