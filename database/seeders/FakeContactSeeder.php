<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FakeContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for( $i = 0; $i < 10; $i++ ) {
            DB::table('contacts')->insert( [
                'user_id' => 1,
                'group_id' => 0,
                'name' => Str::random(10),
                'phone' => Str::random( 12 )
            ] );
        }
    }
}
