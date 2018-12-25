<?php


use Phinx\Seed\AbstractSeed;

class FillCategoriesTable extends AbstractSeed
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
        $table = $this->table('categories');

        for($i = 0; $i < 10; $i++) {
            $table->insert([
               'name' => $faker->firstName
            ]);
        }
        $table->save();
    }
}
