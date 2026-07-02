<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('real_estate_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mouza_id')->constrained('mouzas')->onDelete('cascade');

            // Field Info
            $table->string('field_number')->unique();
            $table->string('intiqal_no')->nullable();
            $table->string('area_quantity');         // e.g. "5"
            $table->string('area_unit')->default('Marla'); // Marla, Kanal, Acre
            $table->decimal('amount', 15, 2)->default(0);
            $table->enum('status', ['available', 'sold'])->default('available');

            // Google Maps pin for this specific field
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Seller Details
            $table->string('seller_name');
            $table->string('seller_cnic')->nullable();
            $table->string('seller_phone')->nullable();
            $table->string('seller_address')->nullable();
            $table->string('seller_father_name')->nullable();

            // Commission Agent (manual per deal)
            $table->string('agent_name')->nullable();
            $table->string('agent_cnic')->nullable();
            $table->string('agent_phone')->nullable();
            $table->string('agent_address')->nullable();
            $table->decimal('agent_commission', 15, 2)->default(0);

            // Patwari Expense
            $table->decimal('patwari_total', 15, 2)->default(0);

            // Bank Link
            $table->foreignId('bank_account_id')->nullable()->constrained('bank_accounts')->onDelete('set null');

            $table->text('notes')->nullable();
            $table->integer('created_by');
            $table->timestamps();
        });

        // Patwari Expense Breakdown Table
        Schema::create('patwari_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('model_type'); // 'field' or 'plot'
            $table->unsignedBigInteger('model_id');
            $table->string('person_name');
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('note')->nullable();
            $table->integer('created_by');
            $table->timestamps();
        });

        // Supporting Documents Table
        Schema::create('real_estate_documents', function (Blueprint $table) {
            $table->id();
            $table->string('model_type'); // 'field' or 'plot'
            $table->unsignedBigInteger('model_id');
            $table->string('document_name');
            $table->string('document_path');
            $table->string('document_type')->nullable(); // Fard, Registry, CNIC, etc.
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('real_estate_documents');
        Schema::dropIfExists('patwari_expenses');
        Schema::dropIfExists('real_estate_fields');
    }
};
