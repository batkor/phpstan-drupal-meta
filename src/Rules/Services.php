<?php

namespace PhpStanDrupalMeta\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;

final class Services extends StaticDrupalRules {

  public function methodName(): string {
    return 'service';
  }

  public function process(Node $node, Scope $scope): array {
    /** @var \PhpParser\Node\Arg $arg */
    $arg = $node->args[0];
    $map = $this->map->getMap('services');

    if (array_key_exists($arg->value->value, $map)) {
      return [];
    }

    return [sprintf('Service "%s" is not defined', $arg->value->value)];
  }

}
