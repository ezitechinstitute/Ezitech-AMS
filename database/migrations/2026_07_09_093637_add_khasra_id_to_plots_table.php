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
        Schema::table('plots', function (Blueprint $table) {
            $table->unsignedBigInteger('khasra_id')->nullable()->after('kiwat_id');
            $table->foreign('khasra_id')->references('id')->on('real_estate_fields')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('plots', function (Blueprint $table) {
            $table->dropForeign(['khasra_id']);
            $table->dropColumn('khasra_id');
        });
    }
};
