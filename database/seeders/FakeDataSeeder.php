<?php

namespace Database\Seeders;

use App\Models\Cinema;
use App\Models\Distributor;
use App\Models\DistributorEmail;
use App\Models\Movie;
use App\Models\MovieDistributor;
use App\Models\MovieVersion;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table((new Distributor())->getTable())->truncate();
        DB::table((new DistributorEmail())->getTable())->truncate();
        DB::table((new Cinema())->getTable())->truncate();
        DB::table((new Order())->getTable())->truncate();

        DB::table((new Movie())->getTable())->truncate();
        DB::table((new MovieVersion())->getTable())->truncate();
        DB::table((new MovieDistributor())->getTable())->truncate();

        $this->call([
            CinemaSeeder::class,

            MoviesTableSeeder::class,
        ]);
    }
}
