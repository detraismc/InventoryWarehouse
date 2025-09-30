<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->id();
            $table->string('name', '100');
            $table->string('description', '255')->nullable()->default(null);
            $table->string('address', '255')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name', '100');
            $table->string('description', '255')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->string('name', '100');
            $table->string('description', '255')->nullable()->default(null);
            $table->integer('category_id');
            $table->timestamps();
        });

        Schema::create('item_data', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->integer('warehouse_id');
            $table->integer('quantity')->default(0);
            $table->string('sku', '100')->nullable()->default(null);
            $table->integer('standard_supply_cost')->default(0);
            $table->integer('standard_sell_price')->default(0);
            $table->integer('reorder_level')->default(-1);
            $table->timestamps();
        });

        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('warehouse_id');
            $table->string('entity', '100');
            $table->string('type', '50');
            $table->string('stage', '50');
            $table->integer('transport_fee')->default(0);
            $table->string('notes', '255')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('transaction_item', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id');
            $table->integer('item_id');
            $table->integer('quantity')->default(0);
            $table->integer('revenue')->default(0);
            $table->integer('cost')->default(0);
            $table->timestamps();
        });

        Schema::create('user_log', function (Blueprint $table) {
            $table->id();
            $table->string('sender', '50')->nullable()->default(null);
            $table->string('log_type', '50')->nullable()->default(null);
            $table->string('log', '255')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
