<?php

namespace PhpStanDrupalMeta\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;

class Configurations extends StaticDrupalRules {

  public function methodName(): string {
    return 'config';
  }

  public function process(Node $node, Scope $scope): array {
    /** @var \PhpParser\Node\Arg $arg */
    $arg = $node->args[0];
    $map = $this->map->getMap('configuration');

    if (array_key_exists($arg->value->value, $map)) {
      return [];
    }

    return [sprintf('Configuration "%s" is not defined', $arg->value->value)];
  }

}
