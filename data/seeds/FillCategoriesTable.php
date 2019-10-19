<?php


use App\Enumerations\TablesEnum;
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
        $table = $this->table(TablesEnum::CATEGORIES);
        $slugify = new Cocur\Slugify\Slugify();

        for($i = 0; $i < 10; $i++) {
            $name = $faker->name;
            $table->insert([
               'name' => $name,
                'slug' => $slugify->slugify($name),
                'description' => $faker->text(250)
            ]);
        }
        $table->save();
    }
}
