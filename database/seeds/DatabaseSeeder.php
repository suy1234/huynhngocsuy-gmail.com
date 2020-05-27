<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::unprepared("
        // INSERT INTO users (`username`, `email`, `password`, `status`) VALUES ('admin', 'admin@gmail.com', '".bcrypt('admin')."', 1)
        // ");
    }
}
