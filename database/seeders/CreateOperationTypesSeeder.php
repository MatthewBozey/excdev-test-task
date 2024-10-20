<?php

namespace Database\Seeders;

use App\Models\OperationType;
use Illuminate\Database\Seeder;

class CreateOperationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OperationType::updateOrCreate([
            'name' => 'credit',
        ], [
            'title' => 'Начисление',
        ]);
        OperationType::updateOrCreate([
            'name' => 'debit',
        ], [
            'title' => 'Списание',
        ]);
    }
}
