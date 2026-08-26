<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $username = env('ADMIN_DEFAULT_USERNAME');
        $password = env('ADMIN_DEFAULT_PASSWORD');
        $email    = env('ADMIN_DEFAULT_EMAIL');

        $admin = $this->db
            ->table('admins')
            ->where('username', $username)
            ->get()
            ->getRowArray();

        $data = ['username' => $username, 'email' => $email,];

        // 如果管理員不存在
        if (!$admin) {

            $data['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $data['name'] = '系統管理員';
            $data['role'] = 'super_admin';
            $data['status'] = 'active';
            $data['must_change_password'] = 1;

            $this->db->table('admins')->insert($data);

            return;
        }

        // 如果管理員已存在
        $this->db
            ->table('admins')
            ->where('id', $admin['id'])
            ->update([
                'email' => $email,
            ]);
    }
}