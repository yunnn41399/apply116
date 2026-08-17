<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateApplicationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'candidate_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'birth_date' => [
                'type' => 'DATE',
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'current_school' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
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
        // 一位考生只允許有一份報名基本資料
        $this->forge->addUniqueKey('candidate_id');
        $this->forge->createTable('applications');
    }
    public function down()
    {
        $this->forge->dropTable('applications');
    }
}
