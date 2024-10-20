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
        Schema::table('balance_operation', function (Blueprint $table) {
            $table->after('operation_date', function ($table) {
                $table->foreignId('operation_type_id')->constrained('operation_type')->onDelete('cascade');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_balance', function (Blueprint $table) {
            //
        });
    }
};
