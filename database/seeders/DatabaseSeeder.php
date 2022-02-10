<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
       //İstediğimiz seed dosyasını burada çağırıyoruz.
        $this->call([
                UserSeeder::class,
                QuizSeeder::class,
        ]);
        
        
    }
}

