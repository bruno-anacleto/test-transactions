<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Factory::create('pt_BR');

        $user = User::create([
            'full_name' => 'Nykolas Fornaziero dos Santos',
            'email' => 'nyfornaziero@gmail.com',
            'document_number' => '346.007.218-02',
            'type'=>1,
            'password' => '##123456789##',
        ]);
    }
}
