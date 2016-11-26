<?php

use Phinx\Migration\AbstractMigration;

class UserTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $users=$this->table('users');
        $users->addColumn('name', 'string', array('limit' => 50))
              ->addColumn('email', 'string', array('limit' => 50))
              ->addColumn('username', 'string', array('limit' => 50,'null' =>true))
              ->addColumn('token', 'string', array('limit' => 255,'null' =>true))
              ->addColumn('verified', 'binary', array('default' => 0))
              ->addColumn('password', 'string', array('limit' => 255))
              ->addColumn('created_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
              ->addColumn('updated_at', 'timestamp', array('null' => true))
              ->addIndex(array('email'), array('unique' => true))
              ->save();


    }

    public function down(){
        $this->dropTable('users');
    }
}
