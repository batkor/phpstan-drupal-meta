<?php

namespace PhpStanDrupalMeta\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PhpStanDrupalMeta\MetaMap;

final class Services implements Rule {

  public function __construct(
    protected MetaMap $map,
  ) {}

  public function getNodeType(): string {
    return StaticCall::class;
  }

  public function processNode(Node $node, Scope $scope): array {
    if (!$node->name instanceof Identifier) {
      return [];
    }

    if ($node->class->toCodeString() !== '\Drupal' || $node->name->name != 'service') {
      return [];
    }

    if (empty($node->args)) {
      return [];
    }

    /** @var \PhpParser\Node\Arg $arg */
    $arg = $node->args[0];
    $map = $this->map->getMap('services');

    if (array_key_exists($arg->value->value, $map)) {
      return [];
    }

    return [sprintf('Service "%s" is not defined', $arg->value->value)];
  }

}
