<?php


use Phinx\Migration\AbstractMigration;

class RemovePodcastIdFieldInGalleryTable extends AbstractMigration
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
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('gallery')
            ->removeColumn("podcasts_id")
            ->renameColumn("url", "thumb")
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addColumn('users_id', 'integer', ['default' => 1])
            ->addForeignKey('users_id', 'users', 'id')
            ->addColumn('online', 'boolean', ['default' => 1])
            ->update();
    }
}
