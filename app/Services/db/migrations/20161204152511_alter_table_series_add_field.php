<?php

use Phinx\Migration\AbstractMigration;

class AlterTableSeriesAddField extends AbstractMigration
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
    public function up(){
        $series=$this->table('series');
        $series->addColumn('trailer_url', 'string', array('limit' => 255))->save();

    }

    public function down(){
        $series = $this->table('series');
        $series->removeColumn('trailer_url')
            ->save();

    }
}
