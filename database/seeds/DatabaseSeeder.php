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
    	// chay nhieu thang cung 1 luc
        $this->call([
        	AdminsTableSeeder::class,
        	BrandsTableSeeder::class,
            CategoriesTableSeeder::class,
            ColorsTableSeeder::class,
            SizesTableSeeder::class,
            ProductsTableSeeder::class,
        ]);

        // chay 1 minh AdminsTableSeeder
        //$this->call(AdminsTableSeeder::class);
    }
}
