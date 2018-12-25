<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreatePodcastsTable extends AbstractMigration
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
        $this->table('podcasts')
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('slug', 'string', ['limit' => 300])
            ->addColumn('description', 'string', ['limit' => MysqlAdapter::TEXT_LONG])
            ->addColumn('duration', 'string', ['limit' => 20])
            ->addColumn('thumb', 'string', ['limit' => 300])
            ->addColumn('audio', 'string', ['limit' => 350])
            ->addColumn('categories_id', 'integer')
            ->addColumn('users_id', 'integer')
            ->addForeignKey('categories_id', 'categories')
            ->addForeignKey('users_id', 'users')
            ->addColumn('created_at', 'date')
            ->create();
    }
}
