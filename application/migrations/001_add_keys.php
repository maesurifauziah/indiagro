<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_keys extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => '11',
                        'auto_increment' => TRUE
                ),
                'user_id' => array(
                        'type' => 'INT',
                        'constraint' => '11',
                ),
                'key' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '40',
                ),
                'level' => array(
                        'type' => 'INT',
                        'constraint' => '2',
                ),
                'ignore_limits' => array(
                        'type' => 'TINYINT',
                        'constraint' => '1',
                        'default' => '0',
                ),
                'is_private_key' => array(
                        'type' => 'TINYINT',
                        'constraint' => '1',
                        'default' => '0',
                ),
                'ip_addresses' => array(
                        'type' => 'TEXT',
                ),
                'date_created' => array(
                        'type' => 'INT',
                        'constraint' => '11',
                ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('keys');
    }

    public function down()
    {
            $this->dbforge->drop_table('keys');
    }
}