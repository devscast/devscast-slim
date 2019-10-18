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
            'name' => getenv('DEFAULT_ADMIN_NAME'),
            'email' => getenv('DEFAULT_ADMIN_EMAIL'),
            'password' => password_hash(getenv('DEFAULT_ADMIN_PASS'), PASSWORD_BCRYPT)
        ]);
        $table->save();
    }
}
