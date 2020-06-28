<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Ports\Command;

use HaydenPierce\ClassFinder\ClassFinder;
use Rmr\Infrastructure\Utils\Resource\ResourceApiGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenerateApiCommand
 * @package Rmr\Ports\Command
 */
final class GenerateApiCommand extends Command
{
    protected static $defaultName = 'app:generate-api';

    private ResourceApiGenerator $resourceApiGenerator;

    /**
     * GenerateApiCommand constructor.
     * @param ResourceApiGenerator $resourceApiGenerator
     */
    public function __construct(ResourceApiGenerator $resourceApiGenerator)
    {
        parent::__construct();

        $this->resourceApiGenerator = $resourceApiGenerator;
    }

    protected function configure(): void
    {
        $this->setDescription('Generates basic API for existent resources.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $resourceApiGenerator = $this->resourceApiGenerator;
        $resources = ClassFinder::getClassesInNamespace('Rmr\Application\Resource', ClassFinder::RECURSIVE_MODE);

        array_walk(
            $resources,
            static function (string $resource) use ($resourceApiGenerator): void {
                $resourceReflection = new \ReflectionClass($resource);

                if (true === $resourceReflection->isInterface() || true === $resourceReflection->isAbstract()) {
                    return;
                }

                $resourceApiGenerator->generate($resourceReflection);
            }
        );

        $output->writeln('API generated');

        return 0;
    }
}
