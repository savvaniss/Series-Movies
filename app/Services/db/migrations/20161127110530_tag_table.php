<?php

use Phinx\Migration\AbstractMigration;

class TagTable extends AbstractMigration
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
        $tags=$this->table('tags');
        $tags->addColumn('value', 'string', array('limit' => 120))
            ->addColumn('slug', 'string', array('limit' => 120))
            ->addColumn('created_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('updated_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->save();


    }

    public function down(){
        $this->dropTable('tags');
    }

}
