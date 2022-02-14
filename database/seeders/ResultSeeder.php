<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
{
    

    public function run()
    {
        \App\Models\Result::factory(20)->create();
    }
}
