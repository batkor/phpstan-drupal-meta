<?php

namespace PhpStanDrupalMeta\Rules\EntityTypes\Storage;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Type;
use PhpStanDrupalMeta\MetaMap;

class CheckStorageMethods implements DynamicMethodReturnTypeExtension {

  public function __construct(
    protected MetaMap $map,
  ) {}

  public function getClass(): string {
    return EntityTypeManagerInterface::class;
  }

  public function isMethodSupported(MethodReflection $methodReflection): bool {
    return $methodReflection->getName() === 'getStorage';
  }

  public function getTypeFromMethodCall(
    MethodReflection $methodReflection,
    MethodCall $methodCall,
    Scope $scope,
  ): ?Type {
    if (count($methodCall->getArgs()) === 0) {
      return NULL;
    }

    $target = $methodCall->getArgs()[0]->value->value;
    $map = $this->map->getMap('entity_types');

    if (!\array_key_exists($target, $map)) {
      return NULL;
    }

    return NULL;
  }

}
