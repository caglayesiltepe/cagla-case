<?php

namespace App\Service;

use App\Repository\DeveloperRepository;

class DeveloperService
{
    private DeveloperRepository $repository;

    public function __construct(DeveloperRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllDevelopers(): array
    {
        return $this->repository->findAll();
    }

    public function developerEfficiency(array $developers): array
    {
        if (empty($developers)) {
            return [];
        }

        $developerEfficiency = [];
        $developerLoad = [];

        foreach ($developers as $developer) {
            $developerEfficiency[$developer->getId()] = $developer->getDuration() / $developer->getDifficulty();
            $developerLoad[$developer->getId()] = 0;
        }

        return ['efficiency' => $developerEfficiency, 'load' => $developerLoad];
    }
}