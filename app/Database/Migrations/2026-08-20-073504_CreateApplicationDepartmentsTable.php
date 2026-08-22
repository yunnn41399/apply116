<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateApplicationDepartmentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'application_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'department_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'confirmed_at' => [
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
        // 同一份報名資料不能重複正式報名同一校系
        $this->forge->addUniqueKey([
            'application_id',
            'department_id',
        ]);
        $this->forge->createTable(
            'application_departments'
        );
    }
    public function down()
    {
        $this->forge->dropTable(
            'application_departments'
        );
    }
}
