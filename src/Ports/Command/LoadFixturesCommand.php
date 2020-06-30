<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Ports\Command;

use Nelmio\Alice\Loader\NativeLoader;
use Rmr\Infrastructure\Adapter\EntityManagerAdapter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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
        $this
            ->setDescription('Loads fixtures into database for specified environment (dev by default).')
            ->addOption('env', null, InputArgument::OPTIONAL);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Nelmio\Alice\Throwable\LoadingThrowable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $env = $input->getOption('env') ?? 'dev';
        $loadedFixtures = $this->entityManager->loadFixtures(["_{$env}.yaml"]);

        $output->writeln("Fixtures loaded: {$loadedFixtures}");

        return 0;
    }
}
