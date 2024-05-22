<?php

use App\Models\OrderDetail;
use App\OrderDetailLength;
use App\OrderDetailStatus;
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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('length')->default(OrderDetailLength::NORMAL);
            $table->string('status')->default(OrderDetailStatus::SUBMITTED);
            $table->string('info');
            $table->boolean('ordered')->default(true);
            $table->unsignedInteger('supplier_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
