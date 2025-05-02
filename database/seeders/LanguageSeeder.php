<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("languages")->delete();
        \DB::table("languages")->insert(
            [
                ['name' => 'English','code'=>'en','status'=>1],
                ['name' => 'Amharic','code'=>'am','status'=>1],
                ['name' => 'Somali','code'=>'so','status'=>1],
                ['name' => 'Oromo','code'=>'om','status'=>1],
            ]
        );
    }
}
