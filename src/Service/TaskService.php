<?php

namespace App\Service;

use App\Repository\TaskRepository;

class TaskService {
    private $repository;

    public function __construct(TaskRepository $repository) {
        $this->repository = $repository;
    }

    public function getAllTasks(): array {
        return $this->repository->findAllOrderByValueDesc();
    }
}