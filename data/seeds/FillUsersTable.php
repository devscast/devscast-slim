<?php


use App\Enumerations\TablesEnum;
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
        $table = $this->table(TablesEnum::USERS);
        $user = $this->query(
            sprintf(
                "SELECT * FROM %s WHERE users.email = %s",
                TablesEnum::USERS,
                getenv('DEFAULT_ADMIN_EMAIL')
            )
        );

        if ($user) {
            $table->insert([
                'name' => getenv('DEFAULT_ADMIN_NAME'),
                'email' => getenv('DEFAULT_ADMIN_EMAIL'),
                'password' => password_hash(getenv('DEFAULT_ADMIN_PASS'), PASSWORD_BCRYPT)
            ]);
            $table->save();
        }
    }
}
