<?php 
require('../Velvet/Velvet.php');

use Velvet\Velvet;

$welcome_message = "Hello World";

$input_dir  = __DIR__ . '/template';
$output_dir = __DIR__ . '/cache';

$velvet = new Velvet($input_dir, $output_dir);
$velvet->compileAll();