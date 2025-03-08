<?php

namespace PhpStanDrupalMeta\Drush\Assets\Php;

use PhpStanDrupalMeta\Drush\Assets\BaseAssets;

class Configuration extends BaseAssets {

  public function filename(): string {
    return 'configuration.php';
  }

  public function vars(): array {
    return [
      'configs' => $this->generator->getHelper('config_info')->getConfigNames(),
    ];
  }

  public function template(): string {
    return <<<'TWIG'
<?php
  return [
  {% for config in configs %}
    '{{ config }}',
  {% endfor %}
  ];

TWIG;
  }

}
