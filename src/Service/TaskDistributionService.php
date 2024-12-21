<?php

namespace App\Service;

use App\Entity\Task;
use App\Entity\Developer;

class TaskDistributionService
{
    private DeveloperService $developerService;

    public function __construct(DeveloperService $developerService)
    {
        $this->developerService = $developerService;
    }

    /**
     * @param Developer[] $developers
     * @param Task[] $tasks
     * @return array
     * @throws \Exception
     */
    public function assignTasks(array $developers, array $tasks): array
    {
        $calculateDeveloperEfficiency = $this->developerService->developerEfficiency($developers);

        if(empty($calculateDeveloperEfficiency)) {
            throw new \Exception('Developer efficiency is empty');
        }

        $developerEfficiency = $calculateDeveloperEfficiency['efficiency'];
        $developerLoad = $calculateDeveloperEfficiency['load'];

        if(empty($tasks)) {
            throw new \Exception('Tasks is empty');
        }

        $developerTasks = [];
        foreach ($tasks as $task) {
            $taskValue = $task->getValue();

            $bestDeveloper = null;
            $minTime = PHP_INT_MAX;
            foreach ($developerLoad as $developerId => $currentLoad) {
                $timeToComplete = $taskValue * $developerEfficiency[$developerId];
                $totalTime = $currentLoad + $timeToComplete;
                if ($totalTime < $minTime) {
                    $minTime = $totalTime;
                    $bestDeveloper = $developerId;
                }
            }

            $timeToComplete = $taskValue * $developerEfficiency[$bestDeveloper];
            $developerTasks[$bestDeveloper][] = [
                'task' => $task->getId(),
                'developer' => $bestDeveloper,
                'time' => $timeToComplete,
            ];

            $developerLoad[$bestDeveloper] += $timeToComplete;
        }

        $totalTime = array_sum(array_map(function($tasks) {
            return array_sum(array_column($tasks, 'time'));
        }, $developerTasks));

        $totalWeeks = $totalTime / 45;

        return [
            'assignments' => $developerTasks,
            'total_weeks' => round($totalWeeks, 2),
        ];
    }


}