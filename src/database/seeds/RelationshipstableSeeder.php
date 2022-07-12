<?php

use Illuminate\Database\Seeder;

class RelationshipstableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relationships = factory(App\Relationship::class,100)->create();
    }
}
