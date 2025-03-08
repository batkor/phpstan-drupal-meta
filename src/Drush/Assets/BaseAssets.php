<?php

namespace PhpStanDrupalMeta\Drush\Assets;

use DrupalCodeGenerator\Asset\File;
use PhpStanDrupalMeta\Drush\Generators\MetaMapGenerator;

abstract class BaseAssets implements AssetsInterface {

  protected MetaMapGenerator $generator;

  protected function path(): string {
    return '.' . DIRECTORY_SEPARATOR . '.phpstan.meta' . DIRECTORY_SEPARATOR . ltrim($this->filename(), DIRECTORY_SEPARATOR);
  }

  public function __invoke(MetaMapGenerator $generator): File {
    $this->generator = $generator;

    return File::create($this->path())
      ->inlineTemplate($this->template())
      ->vars($this->vars());
  }

}
