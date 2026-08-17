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
            'university_code' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'university_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'department_code' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'department_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'admission_quota' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'chinese_requirement' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'english_requirement' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'math_a_requirement' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'math_b_requirement' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'social_requirement' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'natural_requirement' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'english_listening_requirement' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('university_code');
        $this->forge->addKey('department_code');
        $this->forge->createTable('departments');
    }
    public function down()
    {
        $this->forge->dropTable('departments');
    }
}