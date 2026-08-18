<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin',
            'password' => password_hash('Admin123456', PASSWORD_DEFAULT),
            'name'     => '系統管理員',
            'role'     => 'super_admin',
            'status'   => 'active',
        ];

        $this->db->table('admins')->insert($data);
    }
}