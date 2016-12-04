<?php

use Phinx\Migration\AbstractMigration;

class DirectorTagRelationship extends AbstractMigration
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
        $director_tag=$this->table('director_tag');
        $director_tag->addColumn('director_id', 'integer')
            ->addColumn('tag_id', 'integer')
            ->addColumn('created_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('updated_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->save();
        $director_tag
            ->addForeignKey('tag_id', 'tags', 'id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'))
            ->addForeignKey('director_id', 'directors', 'id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'))
            ->save();

    }

    public function down(){
        $this->dropTable('director_tag');
    }
}
