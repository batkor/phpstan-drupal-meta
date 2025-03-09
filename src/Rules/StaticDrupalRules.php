<?php

namespace PhpStanDrupalMeta\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PhpStanDrupalMeta\MetaMap;

abstract class StaticDrupalRules implements Rule, StaticDrupalRulesInterface {

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

    if ($node->class->toCodeString() !== '\Drupal' || $node->name->name != $this->methodName()) {
      return [];
    }

    return $this->process($node, $scope);
  }

}
