<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plots', function (Blueprint $table) {
            if (!Schema::hasColumn('plots', 'mouza_id')) {
                $table->unsignedBigInteger('mouza_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('plots', 'area_acre')) {
                $table->decimal('area_acre', 10, 2)->nullable()->default(0);
            }
            if (!Schema::hasColumn('plots', 'area_kanal')) {
                $table->decimal('area_kanal', 10, 2)->nullable()->default(0);
            }
            if (!Schema::hasColumn('plots', 'area_marla')) {
                $table->decimal('area_marla', 10, 2)->nullable()->default(0);
            }
        });

        if (!$this->foreignKeyExists('plots', 'plots_mouza_id_foreign')) {
            Schema::table('plots', function (Blueprint $table) {
                $table->foreign('mouza_id')->references('id')->on('mouzas')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::table('plots', function (Blueprint $table) {
            if (Schema::hasColumn('plots', 'mouza_id')) {
                $table->dropForeign(['mouza_id']);
                $table->dropColumn('mouza_id');
            }
            if (Schema::hasColumn('plots', 'area_acre')) {
                $table->dropColumn('area_acre');
            }
            if (Schema::hasColumn('plots', 'area_kanal')) {
                $table->dropColumn('area_kanal');
            }
            if (Schema::hasColumn('plots', 'area_marla')) {
                $table->dropColumn('area_marla');
            }
        });
    }

    private function foreignKeyExists(string $table, string $constraintName): bool
    {
        $conn = Schema::getConnection();
        $dbName = $conn->getDatabaseName();

        $result = $conn->select(
            "SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS
             WHERE CONSTRAINT_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_NAME = ?",
            [$dbName, $table, $constraintName]
        );

        return count($result) > 0;
    }
};
