<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateDepartmentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'university_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'department_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'public_private' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'college_group' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'admission_quota' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'description' => [
                'type' => 'TEXT',
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
        $this->forge->createTable('departments');
    }
    public function down()
    {
        $this->forge->dropTable('departments');
    }
}