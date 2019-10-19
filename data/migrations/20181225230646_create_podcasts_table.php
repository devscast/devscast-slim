<?php


use App\Enumerations\TablesEnum;
use Phinx\{Db\Adapter\MysqlAdapter, Migration\AbstractMigration};

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
        $this->table(TablesEnum::PODCASTS)
            // Basic Information
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('slug', 'string', ['limit' => 300])
            ->addColumn('body', 'string', ['limit' => MysqlAdapter::TEXT_LONG])

            // Audio or Video Podcast
            ->addColumn('duration', 'string', ['limit' => 20, 'null' => true])
            ->addColumn('thumb_url', 'string', ['limit' => 300, "null" => true])
            ->addColumn('audio_url', 'string', ['limit' => 350, "null" => true])
            ->addColumn('video_url', 'string', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true])
            ->addColumn('online', 'boolean', ['default' => 0])

            // ForeignKey and Timestamps (updated_at & created_at)
            ->addColumn('categories_id', 'integer')
            ->addColumn('users_id', 'integer')
            ->addForeignKey('categories_id', 'categories')
            ->addForeignKey('users_id', 'users')
            ->addTimestamps()
            ->create();
    }
}
