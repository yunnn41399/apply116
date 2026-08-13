<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNameToCandidates extends Migration
{
    public function up()
    {
        $this->forge->addColumn('candidates', [
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('candidates', 'name');
    }
}