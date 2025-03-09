<?php

namespace PhpStanDrupalMeta\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;

interface StaticDrupalRulesInterface {

  public function methodName(): string;

  public function process(Node $node, Scope $scope): array;

}
