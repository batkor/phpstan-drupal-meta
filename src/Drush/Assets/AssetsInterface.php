<?php

namespace PhpStanDrupalMeta\Drush\Assets;

interface AssetsInterface {

  public function filename(): string;

  public function vars(): array;

  public function template(): string;

}
