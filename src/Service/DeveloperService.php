<?php

namespace App\Service;

use App\Repository\DeveloperRepository;

class DeveloperService {
    private $repository;

    public function __construct(DeveloperRepository $repository) {
        $this->repository = $repository;
    }

    public function getAllDevelopers(): array {
        return $this->repository->findAll();
    }
}