<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'admin_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],

            'action' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],

            'description' => [
                'type' => 'TEXT',
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addKey('admin_id');

        $this->forge->createTable('admin_logs');
    }

    public function down()
    {
        $this->forge->dropTable('admin_logs');
    }
}