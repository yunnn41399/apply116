<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMustChangePasswordToAdmins extends Migration
{
    public function up()
    {
        $fields = [
            'must_change_password' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'null'       => false,
                'after'      => 'status',
            ],
        ];

        $this->forge->addColumn('admins', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn(
            'admins',
            'must_change_password'
        );
    }
}