<?php

namespace Database\Seeders;

use App\Models\Cinema;
use App\Models\Distributor;
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
        DB::table((new Cinema())->getTable())->truncate();
        DB::table((new Order())->getTable())->truncate();

        $this->call([
            DistributorSeeder::class,
            CinemaSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
