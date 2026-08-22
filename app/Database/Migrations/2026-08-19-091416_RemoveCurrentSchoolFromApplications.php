<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class RemoveCurrentSchoolFromApplications extends Migration
{
    public function up()
    {
        $this->forge->dropColumn(
            'applications',
            'current_school'
        );
    }
    public function down()
    {
        $this->forge->addColumn(
            'applications',
            [
                'current_school' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => false,
                    'after' => 'email',
                ],
            ]
        );
    }
}
