<?php

use Phinx\Migration\AbstractMigration;

class AuditTable extends AbstractMigration
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
        $audits=$this->table('audits');
        $audits->addColumn('route', 'string', array('limit' => 100,'null' => true))
            ->addColumn('method', 'string', array('limit' => 50,'null' => true))
            ->addColumn('userid', 'integer')
            ->addColumn('created_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('updated_at', 'timestamp', array('null' => true))
            ->save();


    }

    public function down(){
        $this->dropTable('audits');
    }
}
