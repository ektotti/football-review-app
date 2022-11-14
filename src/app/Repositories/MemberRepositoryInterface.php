<?php
namespace App\Repositories;

interface MemberRepositoryInterface {
    public function getByFixtureId($fixtureId);
}