<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use App\Traits\InteractsWithJsonFiles;

class CountrySeeder extends Seeder
{
    use InteractsWithJsonFiles;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (file_exists(
            $path = base_path('vendor/mledoze/countries/countries.json')
        )) {
            $data = $this->readJson($path);

            $this->command->info("{$data->count()} countries were found.");

            $data->sortBy('name.common')->map(function($country) {
                Country::create([
                    'title' => $country['name']['common'],
                ])->option($country);
            });
        }
    }
}
