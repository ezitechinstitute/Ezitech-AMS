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
        Schema::create('construction_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('construction_project_id')->constrained('construction_projects')->onDelete('cascade');
            $table->string('field_number')->unique();
            $table->string('intiqal_no')->nullable();
            $table->string('area_quantity');
            $table->string('area_unit')->default('Marla');
            $table->decimal('area_acre', 10, 2)->default(0);
            $table->decimal('area_kanal', 10, 2)->default(0);
            $table->decimal('area_marla', 10, 2)->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('seller_name');
            $table->string('seller_cnic')->nullable();
            $table->string('seller_phone')->nullable();
            $table->string('seller_address')->nullable();
            $table->string('seller_father_name')->nullable();
            $table->string('agent_name')->nullable();
            $table->string('agent_cnic')->nullable();
            $table->string('agent_phone')->nullable();
            $table->string('agent_address')->nullable();
            $table->decimal('agent_commission', 15, 2)->default(0);
            $table->decimal('patwari_total', 15, 2)->default(0);
            $table->foreignId('bank_account_id')->nullable()->constrained('bank_accounts')->onDelete('set null');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('construction_fields');
    }
};
