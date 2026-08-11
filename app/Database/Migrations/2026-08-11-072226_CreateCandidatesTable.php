<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCandidatesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'exam_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'id_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addUniqueKey('exam_number');
        $this->forge->addUniqueKey('id_number');

        $this->forge->createTable('candidates');
    }

    public function down()
    {
        $this->forge->dropTable('candidates');
    }
}