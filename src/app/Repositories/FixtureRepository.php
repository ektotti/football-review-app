<?php

namespace App\Repositories;

use App\Fixture;

class FixtureRepository implements FixtureRepositoryInterface
{
    public function getById($id)
    {
        return Fixture::find($id);
    }
}
