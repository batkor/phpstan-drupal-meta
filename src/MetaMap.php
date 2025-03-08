<?php

namespace PhpStanDrupalMeta;

use PhpParser\Node\Arg;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeAbstract;
use PHPStan\Parser\SimpleParser;

class MetaMap {

  protected array $store = [];

  public function __construct(
    protected readonly SimpleParser $parser,
    protected readonly string $metaDir,
  ) {}

  public function getMap(string $key): array {
    if (empty($this->store[$key])) {
      $this->buildMap($key);
    }

    return $this->store[$key] ?? [];
  }

  /**
   * @throws \Exception
   */
  public function buildMap(string $key): void {
    $dir = realpath($this->metaDir);

    if (empty($dir)) {
      throw new \Exception(sprintf('Not found directory "%s"', $this->metaDir));
    }

    $mapFilePath = realpath($this->metaDir) . DIRECTORY_SEPARATOR . "$key.php";

    if (!file_exists($mapFilePath)) {
      return;
    }

    $this->store[$key] = include_once $mapFilePath;
  }

}
