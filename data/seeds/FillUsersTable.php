<?php


use Phinx\Seed\AbstractSeed;

class FillUsersTable extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $table = $this->table('users');

        $table->insert([
            'name' => 'admin',
            'email' => 'admin@devscast.com',
            'password' => password_hash('admin', PASSWORD_BCRYPT)
        ]);
        $table->save();
    }
}
