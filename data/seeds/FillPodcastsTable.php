<?php


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
        $table = $this->table('podcasts');

        for ($i = 0; $i < 20; $i++) {
            $table->insert([
                'name' => $faker->paragraphs(4, true),
                'description' => $faker->text(300),
                'duration' => mt_rand(5, 50),
                'thumb' => 'http://localhost/photofills',
                'audio' => 'http://localhost/audio/test.mp3',
                'slug' => $faker->slug,
                'users_id' => mt_rand(1, 5),
                'categories_id' => mt_rand(1, 5),
                'created_at' => date('Y:M:d H:i:s', $faker->unixTime('now')),
            ]);
        }
        $table->save();
    }
}
