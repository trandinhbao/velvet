<?php

namespace Velvet\FileSystem;

/**
 * The FileSystemInterface interface allows developer to
 * implement their own file system, instead of relied on
 * Velvet default FileSystem class or string-passes
 * template
 */

interface FileSystemInterface {
  function getFileName();
  function getFilePath();
  function getBaseDir();
}
