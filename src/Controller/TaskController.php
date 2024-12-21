<?php

namespace App\Controller;

use App\Service\DeveloperService;
use App\Service\TaskDistributionService;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{
    private TaskService $taskService;
    private DeveloperService $developerService;
    private TaskDistributionService $taskDistributionService;

    public function __construct(TaskService $taskService, DeveloperService $developerService,TaskDistributionService $taskDistributionService)
    {
        $this->taskService = $taskService;
        $this->developerService = $developerService;
        $this->taskDistributionService = $taskDistributionService;
    }

    /**
     * @Route("/task", name="app_task")
     */
    public function index(): Response
    {
        try {
            $tasks = $this->taskService->getAllTasks();
            $developers = $this->developerService->getAllDevelopers();

            $response = $this->taskDistributionService->assignTasks($developers, $tasks);

            return $this->render('task/index.html.twig', [
                'schedule' => $response,
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException('Bir hata oluştu: ' . $e->getMessage());
        }
    }
}
