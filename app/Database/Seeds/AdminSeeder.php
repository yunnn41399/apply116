<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $username = env('ADMIN_DEFAULT_USERNAME');
        $password = env('ADMIN_DEFAULT_PASSWORD');

        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'name'     => '系統管理員',
            'role'     => 'super_admin',
            'status'   => 'active',
            'must_change_password' => 1,
        ];

        $this->db->table('admins')->insert($data);
    }
}