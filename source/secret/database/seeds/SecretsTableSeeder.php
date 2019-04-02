<?php

use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SecretsTableSeeder extends Seeder
{
    private $databaseManager;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->databaseManager->table('secrets')->truncate();

        $ids = [
            Str::uuid(),
            Str::uuid(),
            Str::uuid(),
            Str::uuid(),
            Str::uuid()
        ];

        $now = Carbon::now();

        $this->databaseManager->table('secrets')->insert([
            [
                'id' => $ids[0],
                'name' => 'amber',
                'latitude' => 42.8805,
                'longitude' => -8.54569,
                'location_name' => 'Santiago de Compostela',
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString()
            ],
            [
                'id' => $ids[1],
                'name' => 'diamond',
                'latitude' => 38.2622,
                'longitude' => -0.70107,
                'location_name' => 'Elche',
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString()
            ],
            [
                'id' => $ids[2],
                'name' => 'pearl',
                'latitude' => 41.8919,
                'longitude' => 2.5113,
                'location_name' => 'Rome',
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString()
            ],
            [
                'id' => $ids[3],
                'name' => 'ruby',
                'latitude' => 53.4106,
                'longitude' => -2.9779,
                'location_name' => 'Liverpool',
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString()
            ],
            [
                'id' => $ids[4],
                'name' => 'sapphire',
                'latitude' => 50.08804,
                'longitude' => 14.42076,
                'location_name' => 'Prague',
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString()
            ]
        ]);
    }
}
