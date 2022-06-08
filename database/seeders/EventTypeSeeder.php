<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Psy\Util\Str;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_types')->insert([
            'name' => Str::random(10),
            'create_at'=>time()
        ]);
    }
}
