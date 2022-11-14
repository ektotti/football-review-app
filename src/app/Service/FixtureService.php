<?php 
namespace App\Service;

use App\Repositories\FixtureRepositoryInterface;

class FixtureService {
    public $fixtureRepository;

    public function __construct(FixtureRepositoryInterface $fixtureRepository) {
        $this->fixtureRepository = $fixtureRepository;
    }

    public function getById($id) {
        return $this->fixtureRepository->getById($id);
    }

}