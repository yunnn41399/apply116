<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class AddStatusToApplications extends Migration
{
    public function up()
    {
        $this->forge->addColumn('applications', [
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'draft',
                'after' => 'email',
            ],
        ]);
    }
    public function down()
    {
        $this->forge->dropColumn(
            'applications',
            'status'
        );
    }
}
