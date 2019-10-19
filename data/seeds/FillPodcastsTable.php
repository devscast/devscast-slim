<?php


use App\TablesEnum;
use Phinx\Seed\AbstractSeed;

class FillPodcastsTable extends AbstractSeed
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
        $faker = \Faker\Factory::create('fr_fR');
        $table = $this->table(TablesEnum::PODCASTS);
        $slugify = new Cocur\Slugify\Slugify();

        for ($i = 0; $i < 20; $i++) {
            $name = $faker->text(40);
            $table->insert([
                'name' => $name,
                'description' => $faker->text(300),
                'duration' => mt_rand(5, 50),
                'thumb' => 'https://picsum.photos/200/300',
                'audio' => 'https://lushitrap.com/assets/artists/bernard-ng/audio/Calm_lushitrapMUSIC.mp3',
                'slug' => $slugify->slugify($name),
                'users_id' => 1,
                'categories_id' => mt_rand(1, 5),
                'created_at' => date('Y:M:d H:i:s', time()),
            ]);
        }
        $table->save();
    }
}
