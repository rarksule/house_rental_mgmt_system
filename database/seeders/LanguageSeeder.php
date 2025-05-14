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
                ['name' => 'አማርኛ','code'=>'am','status'=>1],
                ['name' => 'Af somali','code'=>'so','status'=>1],
                ['name' => 'Afaan Oromoo','code'=>'om','status'=>1],
            ]
        );
    }
}
