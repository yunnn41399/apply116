<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHomepagePageGroups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'group_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],

            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],

            'is_enabled' => [
                'type'       => 'INTEGER',
                'constraint' => 1,
                'default'    => 1,
            ],

            'display_mode' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'always',
            ],

            'start_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'end_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'before_message' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],

            'after_message' => [
                'type'       => 'TEXT',
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

        $this->forge->addUniqueKey('group_key');

        $this->forge->createTable('homepage_page_groups');
    }

    public function down()
    {
        $this->forge->dropTable('homepage_page_groups');
    }
}