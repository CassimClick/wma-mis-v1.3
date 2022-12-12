<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class DataSeeder extends Seeder
{
    public function run()
    {
   
        for ($i = 0; $i < 2890; $i++) {
            $this->db->table('visitors')->insert($this->generateVisitors());
        }
    }

    public function generateVisitors():array{
       $faker = Factory::create();
       return [
        'name' => $faker->name,
        'email' => $faker->email,
       ];
    }
}
