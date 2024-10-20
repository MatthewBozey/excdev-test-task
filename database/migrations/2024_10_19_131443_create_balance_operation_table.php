<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('balance_operation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount');
            $table->string('description')->nullable(false);
            $table->timestamp('operation_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('balance_operation');
    }
};
