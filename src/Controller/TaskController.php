<?php

namespace App\Controller;

use App\Service\DeveloperService;
use App\Service\TaskDistributionService;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    private $taskService;
    private $developerService;
    private $taskDistributionService;
    public function __construct(TaskService $taskService, DeveloperService $developerService) {
        $this->taskService = $taskService;
        $this->developerService = $developerService;
        $this->taskDistributionService = new TaskDistributionService();
    }
    /**
     * @Route("/task", name="app_task")
     */
    public function index(): Response
    {
        $tasks = $this->taskService->getAllTasks();
        $developers = $this->developerService->getAllDevelopers();

        $response = $this->taskDistributionService->assignTasks($developers, $tasks);

        return $this->render('task/index.html.twig', [
            'schedule' => $response,
        ]);
    }
}
