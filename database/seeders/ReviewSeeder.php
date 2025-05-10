<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->delete();

        DB::table('reviews')->insert([
            [
                'house_id'=>1,
                'tenant_id'=>3,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'house_id'=>1,
                'tenant_id'=>6,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>1,
                'tenant_id'=>8,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>1,
                'tenant_id'=>9,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>2,
                'tenant_id'=>3,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>2,
                'tenant_id'=>6,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>2,
                'tenant_id'=>8,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>2,
                'tenant_id'=>9,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>3,
                'tenant_id'=>3,
                'rating'=>3,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>3,
                'tenant_id'=>6,
                'rating'=>3,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>3,
                'tenant_id'=>8,
                'rating'=>3,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>3,
                'tenant_id'=>9,
                'rating'=>3,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>4,
                'tenant_id'=>6,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>4,
                'tenant_id'=>8,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>4,
                'tenant_id'=>9,
                'rating'=>5,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>5,
                'tenant_id'=>9,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>6,
                'tenant_id'=>8,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>7,
                'tenant_id'=>3,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>7,
                'tenant_id'=>3,
                'rating'=>5,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>7,
                'tenant_id'=>9,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>8,
                'tenant_id'=>3,
                'rating'=>1,
                'comment'=>'expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>8,
                'tenant_id'=>3,
                'rating'=>1,
                'comment'=>'expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>2,
                'tenant_id'=>6,
                'rating'=>2,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>10,
                'tenant_id'=>3,
                'rating'=>5,
                'comment'=>'interesting I like It',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>10,
                'tenant_id'=>8,
                'rating'=>5,
                'comment'=>'interesting I like It',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>10,
                'tenant_id'=>1,
                'rating'=>1,
                'comment'=>'every thing is a lie',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>1,
                'tenant_id'=>6,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>1,
                'tenant_id'=>6,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>1,
                'tenant_id'=>6,
                'rating'=>4,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>1,
                'tenant_id'=>9,
                'rating'=>2,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'house_id'=>1,
                'tenant_id'=>9,
                'rating'=>3,
                'comment'=>'interesting but expensive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
        ]);
    }
}
