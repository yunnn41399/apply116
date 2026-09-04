<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHomepageMarquees extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'content' => [
                'type'       => 'TEXT',
                'null'       => false,
            ],

            'is_enabled' => [
                'type'       => 'INTEGER',
                'constraint' => 1,
                'default'    => 1,
            ],

            'start_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'end_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('homepage_marquees');
    }

    public function down()
    {
        $this->forge->dropTable('homepage_marquees');
    }
}