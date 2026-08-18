<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class ChangeApplicationsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('applications', [
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'address',
            ],
        ]);
        $this->forge->dropColumn(
            'applications',
            'current_education'
        );
    }
    public function down()
    {
        $this->forge->addColumn('applications', [
            'current_education' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'after' => 'address',
            ],
        ]);
        $this->forge->dropColumn(
            'applications',
            'email'
        );
    }
}
