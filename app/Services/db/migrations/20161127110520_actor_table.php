<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ActorTable extends AbstractMigration
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
        $actors=$this->table('actors');
        $actors->addColumn('first_name', 'string', array('limit' => 120))
            ->addColumn('last_name', 'string', array('limit' => 120))
            ->addColumn('slug', 'string', array('limit' => 240))
            ->addColumn('description', 'text', array('limit' => MysqlAdapter::TEXT_LONG,'null' => true))
            ->addColumn('born_day', 'timestamp', array('null' => true))
            ->addColumn('created_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('updated_at', 'timestamp', array('null' => true))
            ->save();


    }

    public function down(){
        $this->dropTable('actors');
    }
}
