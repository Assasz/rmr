<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Ports\Command;

use Nelmio\Alice\Loader\NativeLoader;
use Rmr\Infrastructure\Adapter\EntityManagerAdapter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class LoadFixturesCommand
 * @package Rmr\Ports\Command
 */
final class LoadFixturesCommand extends Command
{
    protected static $defaultName = 'app:load-fixtures';

    private EntityManagerAdapter $entityManager;

    /**
     * LoadFixturesCommand constructor.
     * @param EntityManagerAdapter $managerAdapter
     */
    public function __construct(EntityManagerAdapter $managerAdapter)
    {
        parent::__construct();

        $this->entityManager = $managerAdapter;
    }

    protected function configure(): void
    {
        $this->setDescription('Loads fixtures into database.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Nelmio\Alice\Throwable\LoadingThrowable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fixtures = (new NativeLoader())->loadFile(dirname(__DIR__, 3) . '/config/fixtures.yaml');

        // TODO: add fixtures persistence mechanism (?)

        foreach ($fixtures->getObjects() as $fixture) {
            $this->entityManager->persist($fixture);
        }

        $this->entityManager->flush();

        $output->writeln('Fixtures loaded: ' . count($fixtures->getObjects()));

        return 0;
    }
}
