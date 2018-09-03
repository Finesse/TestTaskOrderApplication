<?php

use App\Tariff;
use Illuminate\Database\Seeder;

/**
 * Fills the database with mock tariffs
 */
class TariffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tariff::class, rand(3, 7))->create();
    }
}
