<?php

declare(strict_types = 1);

namespace PhpStanDrupalMeta\Drush\Generators;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use PhpStanDrupalMeta\Drush\Assets\AssetsInterface;

#[Generator(
  name: 'phpstan-meta',
  description: 'Generate metadata for phpstan.',
  type: GeneratorType::OTHER,
)]
class MetaMapGenerator extends BaseGenerator {

  protected const DIR = __DIR__ . '/../Assets';

  protected function generate(array &$vars, AssetCollection $assets): void {
    $iterator = new \RecursiveIteratorIterator(
      new \RecursiveDirectoryIterator(self::DIR, \RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $fileinfo) {
      $innerIterator = $iterator->getInnerIterator();
      $subPath = $innerIterator->getSubPath();
      $subNamespace = $subPath ? \str_replace(\DIRECTORY_SEPARATOR, '\\', $subPath) . '\\' : '';
      $class = 'PhpStanDrupalMeta\\Drush\\Assets\\' . $subNamespace . $fileinfo->getBasename('.php');
      $reflect = new \ReflectionClass($class);

      if (!$reflect->implementsInterface(AssetsInterface::class)) {
        continue;
      }

      if ($reflect->isAbstract()) {
        continue;
      }

      $assetInstance = $this
        ->getApplication()
        ->getContainer()
        ->get('class_resolver')
        ->getInstanceFromDefinition($reflect->getName());

      $assets[] = $assetInstance($this);
    }
  }

  protected function getDestination(array $vars): string {
    if (\file_exists(\DRUPAL_ROOT . '/../vendor')) {
      return \DRUPAL_ROOT . '/..';
    }

    return \DRUPAL_ROOT;
  }

}
