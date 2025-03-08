<?php

namespace PhpStanDrupalMeta\Drush\Assets\Php;

use PhpStanDrupalMeta\Drush\Assets\BaseAssets;

final class Services extends BaseAssets {

  public function filename(): string {
    return 'services.php';
  }

  public function vars(): array {
    return [
      'services' => $this->generator->getHelper('service_info')->getServiceClasses(),
    ];
  }

  public function template(): string {
    return <<<'TWIG'
<?php
  return [
  {% for service_id, class in services %}
    '{{ service_id }}' => '{{ class }}',
  {% endfor %}
  ];

TWIG;
  }

}
