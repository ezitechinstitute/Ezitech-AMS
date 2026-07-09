<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Plot table
        Schema::table('plots', function (Blueprint $table) {
            $table->unsignedBigInteger('kiwat_id')->nullable()->after('mouza_id');
            $table->foreign('kiwat_id')->references('id')->on('kiwats')->onDelete('cascade');
        });

        // RealEstateField table
        Schema::table('real_estate_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('kiwat_id')->nullable()->after('mouza_id');
            $table->foreign('kiwat_id')->references('id')->on('kiwats')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('plots', function (Blueprint $table) {
            $table->dropForeign(['kiwat_id']);
            $table->dropColumn('kiwat_id');
        });

        Schema::table('real_estate_fields', function (Blueprint $table) {
            $table->dropForeign(['kiwat_id']);
            $table->dropColumn('kiwat_id');
        });
    }
};
