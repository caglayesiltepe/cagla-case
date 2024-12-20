<?php

namespace App\Service;

use App\Entity\Task;
use App\Entity\Developer;

class TaskDistributionService
{

    /**
     * @param Developer[] $developers
     * @param Task[] $tasks
     * @return array
     */
    public function assignTasks(array $developers, array $tasks): array
    {
        // saat'te ne kadar zorluk derecesi iş çözüyor onu hesaplıyoruz
        $developerEfficiency = [];
        $developerLoad = []; // developerların iş yükünü takip edeceğiz
        foreach ($developers as $developer) {
            $developerEfficiency[$developer->getDeveloperId()] = $developer->getDuration() / $developer->getDifficulty();
            $developerLoad[$developer->getDeveloperId()] = 0;
        }

        // taskları ata
        $developerTasks = [];
        foreach ($tasks as $task) {
            $taskValue = $task->getValue();

            // En hızlı yapacak developerı bul
            $bestDeveloper = null;
            $minTime = PHP_INT_MAX;
            foreach ($developerLoad as $developerId => $currentLoad) {
                $timeToComplete = $taskValue * $developerEfficiency[$developerId];// developerın yapacağı süre
                $totalTime = $currentLoad + $timeToComplete; // Yeni yük (totalTime = mevcut yük + görev süresi)
                if ($totalTime < $minTime) {
                    $minTime = $totalTime; // En kısa tamamlanma süresi
                    $bestDeveloper = $developerId; // Bu geliştiriciye görevi ata
                }
            }

            // Görevi geliştiriciye ata
            $timeToComplete = $taskValue * $developerEfficiency[$bestDeveloper];
            $developerTasks[$bestDeveloper][] = [
                'task' => $task->getTaskId(),
                'developer' => $bestDeveloper,
                'time' => $timeToComplete,
            ];

            // Geliştiricinin yükünü güncelle
            $developerLoad[$bestDeveloper] += $timeToComplete;
        }

        //toplam süreyi hesaplıyoruz
        $totalTime = array_sum(array_map(function($tasks) {
            return array_sum(array_column($tasks, 'time'));
        }, $developerTasks));

        //1 hafta 45 saat çalışma süresi oldugu için 45'e bölüyoruz
        $totalWeeks = $totalTime / 45;

        return [
            'assignments' => $developerTasks,
            'total_weeks' => round($totalWeeks, 2),
        ];
    }


}