<?php

namespace Database\Seeders;

use App\Models\Events;
use App\Models\EventTypes;
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
            'created_at'=>date_timestamp_get(),
            'updated_at'=>date_timestamp_get()
        ]);
    }
}
