<?php

namespace CoffeeScript;

define('COFFEESCRIPT_VERSION', '1.3.1');

class Init {

  public function __construct() {}

  /**
   * Dummy function that doesn't actually do anything, it's just used to make
   * sure that this file gets loaded.
   */
  static function init() {}

  /**
   * This function may be used in lieu of an autoloader.
   */
  static function load($root = NULL)
  {
    if ($root === NULL)
    {
      $root = realpath(dirname(__FILE__));
    }

    $files = array(
      'Helpers',
      'Compiler',
      'Error',
      
      'Lexer',
      'Nodes',
      'Parser',
      'Rewriter',
      'Scope',
      'SyntaxError',
      'Value',

      'yy/Base',  // load the base class first
      'yy/While', // For extends While

      'yy/Access',
      'yy/Arr',
      'yy/Assign',
      'yy/Block',
      'yy/Call',
      'yy/Class',
      'yy/Closure',
      'yy/Code',
      'yy/Comment',
      'yy/Existence',
      'yy/Extends',
      'yy/For',
      'yy/If',
      'yy/In',
      'yy/Index',
      'yy/Literal',
      'yy/Obj',
      'yy/Op',
      'yy/Param',
      'yy/Parens',
      'yy/Range',
      'yy/Return',
      'yy/Slice',
      'yy/Splat',
      'yy/Switch',
      'yy/Throw',
      'yy/Try',
      'yy/Value',
    );

    foreach ($files as $file)
    {
      require_once "$root/$file.php";
    }
  }

}

//
// Function shortcuts. These are all used internally.
//

function args(array $args, $required, array $optional = NULL) { return call_user_func_array('CoffeeScript\Helpers::args', array($args, $required, $optional)); }
//function compact(array $array) { return Helpers::compact($array); }
function del( & $obj, $key) { return call_user_func_array('CoffeeScript\Helpers::del', array($obj, $key)); }
function extend($obj, $properties) { return call_user_func_array('CoffeeScript\Helpers::extend', array($obj, $properties)); }
function flatten(array $array) { return call_user_func_array('CoffeeScript\Helpers::flatten',array($array)); }
function last( & $array, $back = 0) { return call_user_func_array('CoffeeScript\Helpers::last', array($array, $back)); }
function wrap($v) { return call_user_func_array('CoffeeScript\Helpers::wrap',array($v)); }
function t() { return call_user_func_array('CoffeeScript\Lexer::t', func_get_args()); }
function t_canonical() { return call_user_func_array('CoffeeScript\Lexer::t_canonical', func_get_args()); }
function multident($code, $tab) { return call_user_func_array('CoffeeScript\Nodes::multident',array($code, $tab)); }
function unfold_soak($options, $parent, $name) { return call_user_func_array('CoffeeScript\Nodes::unfold_soak',array($options, $parent, $name)); }
function utility($name) { return call_user_func_array('CoffeeScript\Nodes::utility', array($name)); }
function yy() { return call_user_func_array('CoffeeScript\Nodes::yy', func_get_args()); }

?>
