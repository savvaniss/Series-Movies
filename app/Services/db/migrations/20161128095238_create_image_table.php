<?php

use Phinx\Migration\AbstractMigration;

class CreateImageTable extends AbstractMigration
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
        //create table for polymorfic relationship
        //both for series and Actor also slug for url
        $images=$this->table('images');
        $images->addColumn('filename', 'string', array('limit' => 120))
            ->addColumn('hash', 'string', array('limit' => 240))
            ->addColumn('slug', 'string', array('limit' => 240))
            ->addColumn('size', 'string', array('limit' => 240))
            ->addColumn('uploaded_dir', 'string', array('limit' => 240))
            ->addColumn('imagenable_id','integer')
            ->addColumn('imagenable_type','string', array('limit' => 120))
            ->addColumn('created_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('updated_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->save();


    }

    public function down(){
        $this->dropTable('images');
    }
}
