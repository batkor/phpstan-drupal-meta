<?php

namespace PhpStanDrupalMeta\Rules\EntityTypes\Storage;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PhpStanDrupalMeta\MetaMap;

class CallStorage implements Rule {

  public function __construct(
    protected MetaMap $map,
  ) {}

  public function getNodeType(): string {
    return MethodCall::class;
  }

  public function processNode(Node $node, Scope $scope): array {
    if ($node->name->name != 'getStorage') {
      return [];
    }

    $map = $this->map->getMap('entity_types');
    $target = $node->args[0]->value->value;

    return \array_key_exists($target, $map)
      ? []
      : [sprintf('Entity type "%s" is not defined', $target)];
  }

}
