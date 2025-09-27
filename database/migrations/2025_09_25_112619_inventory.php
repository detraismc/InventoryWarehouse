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
            $table->string('description', '255');
            $table->string('location', '255');
            $table->timestamps();
        });

        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name', '100');
            $table->string('description', '255');
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('warehouse_id');
            $table->integer('category_id');
            $table->string('name', '100');
            $table->string('sku', '100');
            $table->integer('quantity');
            $table->integer('reorder_level');
            $table->timestamps();
        });

        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('warehouse_id');
            $table->string('entity', '100');
            $table->string('type', '50');
            $table->string('stage', '50');
            $table->integer('transport_fee');
            $table->string('notes', '255');
            $table->timestamps();
        });

        Schema::create('transaction_item', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id');
            $table->integer('item_id');
            $table->integer('quantity');
            $table->integer('revenue');
            $table->integer('cost');
            $table->timestamps();
        });

        Schema::create('transaction_log', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('transaction_id');
            $table->string('transaction_stage', '50');
            $table->date('date');
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
