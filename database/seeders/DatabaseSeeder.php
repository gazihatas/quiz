<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    
    public function run()
    {   
       //İstediğimiz seed dosyasını burada çağırıyoruz.
        $this->call([
                UserSeeder::class,
                QuizSeeder::class,
                QuestionSeeder::class,
                AnswerSeeder::class,
                ResultSeeder::class
        ]);
        
        
    }
}

