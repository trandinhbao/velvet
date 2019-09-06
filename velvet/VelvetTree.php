<?php

namespace Velvet;

interface VelvetTreeInterface {
  public function __construct();
  /**
   * A Velvet Tree implementation have to implement 
   * toString() method to tranlsate the current tree to code as a string
   * The source is after-processed. The original source don't need to preserved
   */
  public function toString();
}


class TemplateDOMTree implements VelvetTreeInterface {
  public function __construct() {
    
  }
}

class ScriptAST implements VelvetTreeInterface {
  public function __construct() {
    
  }
}

class StyleHashedTree implements VelvetTreeInterface {
  public function __construct() {
    
  }
}
