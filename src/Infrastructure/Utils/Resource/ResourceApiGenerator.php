<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Utils\Resource;

use Rmr\Application\Resource\CollectionResourceInterface;
use Rmr\Application\Resource\ResourceInterface;
use Rmr\Infrastructure\Adapter\TwigAdapter;

/**
 * Class ResourceApiGenerator
 * @package Rmr\Infrastructure\Utils\Resource
 */
final class ResourceApiGenerator
{
    private const ITEM_RESOURCE_OPERATIONS = [
        'operations/item/get.php.twig' => '/Ports/Operation/%s/GetOperation.php',
        'operations/item/remove.php.twig' => '/Ports/Operation/%s/RemoveOperation.php',
        'operations/item/replace.php.twig' => '/Ports/Operation/%s/ReplaceOperation.php',
    ];

    private const COLLECTION_RESOURCE_OPERATIONS = [
        'operations/collection/get.php.twig' => '/Ports/Operation/%sCollection/GetOperation.php',
        'operations/collection/insert.php.twig' => '/Ports/Operation/%sCollection/InsertOperation.php',
    ];

    private TwigAdapter $twig;
    private ResourcesConfigBuilder $resourcesConfigBuilder;
    private ?\ReflectionClass $resourceReflection;
    private ?string $entityName;
    private ?string $rootNamespace;

    /**
     * ResourceApiGenerator constructor.
     * @param TwigAdapter $twig
     * @param ResourcesConfigBuilder $resourcesConfigBuilder
     */
    public function __construct(TwigAdapter $twig, ResourcesConfigBuilder $resourcesConfigBuilder)
    {
        $this->twig = $twig;
        $this->resourcesConfigBuilder = $resourcesConfigBuilder;
    }

    /**
     * @param \ReflectionClass $resourceReflection
     */
    public function generate(\ReflectionClass $resourceReflection): void
    {
        $this->resourceReflection = $resourceReflection;
        $this->entityName = preg_replace('(Resource|CollectionResource)', '', $this->resourceReflection->getShortName());
        $this->rootNamespace = explode('\\', __NAMESPACE__)[0];

        foreach ($this->resolveOperationSet() as $templateName => $outputPath) {
            $this->generateOperation($templateName, $outputPath);
        }

        $this->updateConfiguration();
    }

    /**
     * @param string $templateName
     * @param string $outputPath
     */
    private function generateOperation(string $templateName, string $outputPath): void
    {
        $operationPath = dirname(__DIR__, 3) . sprintf($outputPath, $this->entityName);
        $operationOutputClass = "{$this->rootNamespace}\Infrastructure\Dto\\{$this->entityName}Iri";

        $operationContent = $this->twig->render($templateName, [
            'rootNamespace' => $this->rootNamespace,
            'resourceNamespace' => $this->resourceReflection->getName(),
            'resourceClassName' => $this->resourceReflection->getShortName(),
            'entityNamespace' => "{$this->rootNamespace}\Domain\Entity\\{$this->entityName}",
            'entityClassName' => $this->entityName,
            'outputNamespace' => (true === class_exists($operationOutputClass)) ? $operationOutputClass : null,
            'outputClassName' => (true === class_exists($operationOutputClass)) ? "{$this->entityName}Iri" : null,
        ]);

        $this->write($operationPath, $operationContent);
    }

    /**
     * Updates resources.yaml configuration file
     */
    private function updateConfiguration(): void
    {
        $rootNamespace = $this->rootNamespace;
        $entityName = $this->entityName;

        $newConfigRecords = array_map(
            static function (string $operationPath) use ($rootNamespace, $entityName): string {
                return $rootNamespace . rtrim(str_replace('/', '\\', sprintf($operationPath, $entityName)), '.php');
            },
            array_values($this->resolveOperationSet())
        );

        $this->resourcesConfigBuilder
            ->selectResource($this->resourceReflection->getName())
            ->mergeOperations(...$newConfigRecords)
            ->save();
    }

    /**
     * @return string[]
     * @throws \InvalidArgumentException
     */
    private function resolveOperationSet(): array
    {
        if ($this->resourceReflection->implementsInterface(CollectionResourceInterface::class)) {
            return self::COLLECTION_RESOURCE_OPERATIONS;
        }

        if ($this->resourceReflection->implementsInterface(ResourceInterface::class)) {
            return self::ITEM_RESOURCE_OPERATIONS;
        }

        throw new \InvalidArgumentException('Unknown resource type.');
    }

    /**
     * @param string $path
     * @param string $content
     */
    private function write(string $path, string $content): void
    {
        $dir = dirname($path);

        if (false === is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (false === file_exists($path)) {
            file_put_contents($path, $content);
        }
    }
}
