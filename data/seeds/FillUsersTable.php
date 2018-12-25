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
        $faker = \Faker\Factory::create('fr_FR');
        $table = $this->table('users');

        for ($i = 0 ; $i < 5; $i++) {
            $table->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => password_hash($faker->password, PASSWORD_BCRYPT)
            ]);
        }
        $table->save();
    }
}
