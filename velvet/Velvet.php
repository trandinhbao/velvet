<?php

namespace Velvet;

/**
 * Velvet - A frontend-oriented PHP Template system to use with Vue
 *
 * @package   Velvet
 * @author    Tran Tran
 * @copyright Copyright (c) 2019 Bao Tran, MIT License
 * @version   0.0.1-alpha
 */
final class Velvet {
  private $source_dir;
  private $destination_dir;
  private $mode;

  public function __construct($source_dir, $destination_dir, $mode = 'development') {
    $this->source_dir = $source_dir;
    $this->destination_dir = $destination_dir;
    $this->mode = $mode;
  }

  public function compileAll() {
    $raw_file = file_get_contents( $this->source_dir . '/front-page.vue');
    $matches = [];

    if (preg_match_all("/<template>(?s).*<\/template>/", $raw_file, $matches)) {
      $templates = $matches[0];
    }
    if (preg_match_all("/<script>(?s).*<\/script>/", $raw_file, $matches)) {
      $scripts = $matches[0];
    }
    if (preg_match_all("/<style>(?s).*<\/style>/", $raw_file, $matches)) {
      $styles = $matches[0];
    }

    foreach ($templates as $template) {
      file_put_contents($this->destination_dir . '/index.html', $template);
    }

    foreach ($scripts as $script) {
      file_put_contents($this->destination_dir . '/index.js', $script);
    }

    foreach ($styles as $style) {
      file_put_contents($this->destination_dir . '/index.css', $style);
    }
  }
}
