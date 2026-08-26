<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordResetFieldsToAdmins extends Migration
{
    public function up()
    {
        $this->forge->addColumn('admins', [

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'name',
            ],

            'password_reset_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'status',
            ],

            'password_reset_expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'password_reset_token',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('admins', [
            'email',
            'password_reset_token',
            'password_reset_expires_at',
        ]);
    }
}