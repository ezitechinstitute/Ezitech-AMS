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
        Schema::table('mouzas', function (Blueprint $table) {
            $table->string('intiqal_number')->nullable()->after('description');
            $table->date('intiqal_date')->nullable()->after('intiqal_number');
            $table->string('total_area')->nullable()->after('intiqal_date');
            $table->string('total_area_unit')->nullable()->after('total_area');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mouzas', function (Blueprint $table) {
            $table->dropColumn(['intiqal_number', 'intiqal_date', 'total_area', 'total_area_unit']);
        });
    }
};
