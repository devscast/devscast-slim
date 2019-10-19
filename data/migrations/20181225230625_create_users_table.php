<?php


use App\Enumerations\{RolesEnum, TablesEnum};
use Phinx\{Db\Adapter\MysqlAdapter, Migration\AbstractMigration};

class CreateUsersTable extends AbstractMigration
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
        $this->table(TablesEnum::USERS)

            // Basic information
            ->addColumn('name', 'string', ['limit' => 60])
            ->addColumn('email', 'string', ['limit' => 60])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('role', 'integer', [
                'limit' => MysqlAdapter::INT_TINY,
                'default' => RolesEnum::USERS
            ])

            // Social Media Links
            ->addColumn('github_url', 'string', ['null' => true])
            ->addColumn('twitter_url', 'string', ['null' => true])
            ->addColumn('website_url', 'string', ['null' => true])

            // Account Confirmation and Reset password
            ->addColumn('account_confirmed_at', 'datetime', ['null' => true])
            ->addColumn('account_confirmation_token', 'string', ['null' => true, 'limit' => 100])
            ->addColumn('password_reset_at', 'datetime', ['null' => true])
            ->addColumn('password_reset_token', 'string', ['null' => true, 'limit' => 100])
            ->addTimestamps()
            ->create();
    }
}
