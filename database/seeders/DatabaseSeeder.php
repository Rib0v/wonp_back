<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\House;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $houses = $this->getDataFromCSV('/database/property-data.csv');
        House::factory()->createMany($houses);

        /**
         * Это на случай, если захочется
         * сгенерировать данных побольше
         */
        //House::factory(50)->create();
    }

    private function getDataFromCSV(string $relativePath): array
    {
        $csv = File::get(base_path() . $relativePath);
        $rows = explode("\n", $csv);
        $headers = str_getcsv(array_shift($rows));
        $headersLowerCased = array_map(fn ($item) => strtolower($item), $headers);

        $data = [];

        foreach ($rows as $row) {
            $data[] = array_combine($headersLowerCased, str_getcsv($row));
        }

        return $data;
    }
}
