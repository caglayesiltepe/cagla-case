<?php

namespace App\Command;

use App\Entity\Developer;
use App\Factory\ProviderFactory;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Enum\ProviderEnum;

class FetchTasksCommand extends Command
{
    protected static $defaultName = 'app:fetch-tasks';

    private EntityManagerInterface $entityManager;
    private ProviderFactory $providerFactory;

    public function __construct(EntityManagerInterface $entityManager, ProviderFactory $providerFactory)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->providerFactory = $providerFactory;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $providers = [ProviderEnum::TASKS, ProviderEnum::DEVELOPERS];
            foreach ($providers as $provider) {
                $tasks = $this->providerFactory->getProviderList($provider);

                if (empty($tasks)) {
                    $output->writeln(ucfirst($provider) . ' are empty.');
                    continue;
                }

                if ($provider === ProviderEnum::TASKS) {
                    $this->handleTasks($tasks);
                } elseif ($provider === ProviderEnum::DEVELOPERS) {
                    $this->handleDevelopers($tasks);
                }

                $output->writeln(ucfirst($provider) . ' fetched and saved.');
            }

            $this->entityManager->flush();

            return ProviderEnum::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());
            return ProviderEnum::FAILURE;
        }
    }

    private function handleTasks(array $tasks):void
    {
        foreach ($tasks as $taskData) {
            $task = new Task();
            $task->setTaskId($taskData['id']);
            $task->setValue($taskData['value']);
            $task->setEstimatedDuration($taskData['estimated_duration']);

            $this->entityManager->persist($task);
        }
    }

    private function handleDevelopers(array $developers):void
    {
        foreach ($developers as $developerData) {
            $developer = new Developer();
            $developer->setDeveloperId($developerData['id']);
            $developer->setDuration($developerData['sure']);
            $developer->setDifficulty($developerData['zorluk']);
            $this->entityManager->persist($developer);
        }
    }
}
