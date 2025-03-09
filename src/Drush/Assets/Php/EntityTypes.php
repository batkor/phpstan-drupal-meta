<?php

namespace PhpStanDrupalMeta\Drush\Assets\Php;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use PhpStanDrupalMeta\Drush\Assets\BaseAssets;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class EntityTypes extends BaseAssets implements ContainerInjectionInterface {

  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {}

  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('entity_type.manager')
    );
  }

  public function filename(): string {
    return 'entity_types.php';
  }

  public function vars(): array {
    $definitions = array_map(static function ($definition) {
      return [
        'class' => $definition->getClass(),
        'storage' => $definition->getStorageClass(),
        'access_control' => $definition->getAccessControlClass(),
        'list_builder' => $definition->getListBuilderClass(),
        'view_builder' => $definition->getViewBuilderClass(),
      ];
    }, $this->entityTypeManager->getDefinitions());

    return [
      'definitions' => $definitions,
    ];
  }

  public function template(): string {
    return <<<'TWIG'
<?php
  return [
  {% for entity_type_id, def in definitions %}
    '{{ entity_type_id }}' => [
      {% for key, class in def %}
      '{{ key }}' => '{{ class }}',
      {% endfor %}
    ],
  {% endfor %}
  ];

TWIG;
  }

}
