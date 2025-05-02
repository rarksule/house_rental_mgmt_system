<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {


        DB::table('users')->delete();

        DB::table('users')->insert([
            [
                'first_name' => 'Abinet',
                'last_name' => 'Tesfaye',
                'email' => 'Abinet@gmail.com',
                'phone_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'contact_number' => '0910111687',
                'status' => USER_STATUS_ACTIVE,
                'role' => USER_ROLE_ADMIN,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Adina',
                'last_name' => 'Bashir',
                'email' => 'Adina@gmail.com',
                'phone_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'contact_number' => '0951110920',
                'status' => USER_STATUS_ACTIVE,
                'role' => USER_ROLE_OWNER,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Dagnachew',
                'last_name' => 'Azmeraw',
                'email' => 'Dagnachew@gmail.com',
                'phone_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'contact_number' => '0941704362',
                'status' => USER_STATUS_ACTIVE,
                'role' => USER_ROLE_TENANT,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Hayat',
                'last_name' => 'Tahir',
                'email' => 'Hayat@gmail.com',
                'phone_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'contact_number' => '0948651456',
                'status' => USER_STATUS_ACTIVE,
                'role' => USER_ROLE_ADMIN,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Hemen',
                'last_name' => 'Ababaw',
                'email' => 'Hemen@gmail.com',
                'phone_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'contact_number' => '0970954570',
                'status' => USER_STATUS_ACTIVE,
                'role' => USER_ROLE_OWNER,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Masiud',
                'last_name' => 'Mahamadnur',
                'email' => 'Masiud@gmail.com',
                'phone_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'contact_number' => '0913151107',
                'status' => USER_STATUS_ACTIVE,
                'role' => USER_ROLE_TENANT,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Munira',
                'last_name' => 'kadir',
                'email' => 'Munira@gmail.com',
                'phone_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'contact_number' => '0937523324',
                'status' => USER_STATUS_ACTIVE,
                'role' => USER_ROLE_ADMIN,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Nasradin',
                'last_name' => 'Abdiwali',
                'email' => 'Nasradin@gmail.com',
                'phone_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'contact_number' => '0915206486',
                'status' => USER_STATUS_ACTIVE,
                'role' => USER_ROLE_OWNER,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'first_name' => 'Tamiru',
                'last_name' => 'Belete',
                'email' => 'Tamiru@gmail.com',
                'phone_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'contact_number' => '0909206317',
                'status' => USER_STATUS_ACTIVE,
                'role' => USER_ROLE_TENANT,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'first_name' => 'Zekeriya',
                'last_name' => 'Niguse',
                'email' => 'Zekeriya@gmail.com',
                'phone_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'contact_number' => '0991439519',
                'status' => USER_STATUS_ACTIVE,
                'role' => USER_ROLE_TENANT,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}