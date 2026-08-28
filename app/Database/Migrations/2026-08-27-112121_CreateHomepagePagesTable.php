<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHomepagePagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'page_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'route' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'location' => [
                'type'       => 'ENUM',
                'constraint' => ['navbar', 'sidebar'],
                'default'    => 'navbar',
            ],

            'is_enabled' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],

            'display_mode' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'always',
                    'message_when_closed',
                    'hide_when_closed'
                ],
                'default' => 'always',
            ],

            'start_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],

            'end_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],

            'before_message' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'after_message' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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
        $this->forge->addUniqueKey('page_key');

        $this->forge->createTable('homepage_pages');
    }

    public function down()
    {
        $this->forge->dropTable('homepage_pages');
    }
}