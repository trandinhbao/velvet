<?php

namespace Velvet;

use Velvet\FileSystem\FileSystemInterface;

/**
 * The main Velvet class
 *
 * @package   Velvet
 * @author    Bao Tran
 * @copyright Copyright (c) 2019 Bao Tran, MIT License
 * @version   0.0.2-alpha
 */
final class Velvet {
  private $source_dir;
  private $destination_dir;
  private $mode;

  /**
   * @param string $source_dir 
   *   The source directory contains template files
   * @param string $destination_dir
   *   The desination directory for compiled templates
   * @param string $mode 
   *   The compile mode
   *    - prod/production will compile to more optimized templates
   *    - dev/development will include debug infomation
   * @param \Velvet\FileSystem\FileSystemInterface $file_system
   *   The file system to load templates 
   */
  public function __construct($source_dir, $destination_dir, $mode = 'development', ?FileSystemInterface $file_system = NULL) {
    $this->source_dir = $source_dir;
    $this->destination_dir = $destination_dir;
    $this->mode = $mode;
  }

  /**
   * @param string $template
   */
  private function adjustTemplate($template) {
    // Replace first <template> tag
    $first_tag_position = \strpos($template, "<template>");
    if ($first_tag_position !== false) {
      $template = substr_replace($template, '<div id="app">', $first_tag_position, strlen('<template>'));
    }

    $last_tag_position = \strpos($template, "</template>");
    if ($last_tag_position !== false) {
      $template = substr_replace($template, '</div>', $last_tag_position, strlen('</template>'));
    } else echo 'notfound ';
    return $template;
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

    $template_output =
<<<HTML
<!DOCTYPE html>
<link rel="stylesheet" href="index.css"/>

<body>

HTML;

    $script_output   = '';
    $style_output    = '';

    foreach ($templates as $template) {
      $template_output .= $this->adjustTemplate($template);
    }

    foreach ($scripts as $script) {
      $script_output .= strip_tags($script);
    }

    foreach ($styles as $style) {
      $style_output .= strip_tags($style);
    }

    $template_output .= 
<<<HTML

</body>

<script src="https://unpkg.com/vue/dist/vue.js"></script>

<script type="module">
  import config from './index.js'

  const vm = new Vue(config)
  vm.\$mount('#app')
  console.log('mounted')
</script>
HTML;

    file_put_contents($this->destination_dir . '/index.html', $template_output);
    file_put_contents($this->destination_dir . '/index.mjs', $script_output);
    file_put_contents($this->destination_dir . '/index.css', $style_output);
  }

  // public function render($template, )
}
