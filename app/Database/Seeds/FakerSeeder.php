<?php namespace App\Database\Seeds;

use CodeIgniter\Config\View;

class FakerSeeder extends \CodeIgniter\Database\Seeder
{
        public function run()
        {
            $faker = \Faker\Factory::create('id_ID');

            $user[] = [
                'nama_depan' => 'Syahrul',
                'nama_belakang'    => 'Ramadhan',
                'email'    => 'sramadhan95@gmail.com',
                'password'    => md5('12345678'),
                'nomor_telepon'    => '085777788713',
                'jabatan'    => 'Konsultan IT',
                'role'    => 'ADMINISTRATOR'
            ];

            for($i=0; $i<100; $i++):
                $user[] = [
                    'nama_depan' => $faker->firstName,
                    'nama_belakang'    => $faker->lastName,
                    'email'    => $faker->email,
                    'password'    => md5('12345678'),
                    'nomor_telepon'    => $faker->phoneNumber,
                    'jabatan'    => 'Staff',
                    'role'    => 'ADMIN_CONTENT'
                ];
            endfor;

            // Using Query Builder
            $this->db->table('user')->insertBatch($user);
        }
}