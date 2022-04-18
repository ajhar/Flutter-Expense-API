<?php

namespace Database\Seeders;

use App\Models\Expense;
use Database\Factories\ExpenseFactory;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Expense::factory()
            ->count(30)
            ->create();
    }
}
