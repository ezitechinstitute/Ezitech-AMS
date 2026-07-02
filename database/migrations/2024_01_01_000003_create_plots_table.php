<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plots', function (Blueprint $table) {
            $table->id();

            // Plot Info
            $table->string('field_number')->unique();
            $table->string('intiqal_no')->nullable();
            $table->string('area_quantity');
            $table->string('area_unit')->default('Marla');
            $table->decimal('amount', 15, 2)->default(0);
            $table->enum('status', ['available', 'sold'])->default('available');

            // Google Maps pin
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Purchaser Details (seller ki jagah purchaser)
            $table->string('purchaser_name');
            $table->string('purchaser_cnic')->nullable();
            $table->string('purchaser_phone')->nullable();
            $table->string('purchaser_address')->nullable();
            $table->string('purchaser_father_name')->nullable();

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
    }

    public function down()
    {
        Schema::dropIfExists('plots');
    }
};
