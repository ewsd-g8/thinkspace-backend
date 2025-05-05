<?php

namespace Database\Seeders;

use App\Models\Closure;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ClosureTableSeeder extends Seeder
{
    public function run()
    {
        $date = now()->addYear();
        $finalDate = (clone $date)->addMonth();

        $closures = [
            [
                'name' => '2025 Winter Submission',
                'date' => $date,
                'final_date' => $finalDate,
            ],
        ];

        foreach ($closures as $closure) {
            Closure::create([
                'name' => $closure['name'],
                'date' => $closure['date'],
                'final_date' => $closure['final_date'],
            ]);
        }
    }
}