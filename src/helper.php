<?php

function kebabToCamelCase(string $string): string
{
  $words = explode('-', strtolower($string));
  $camel = array_shift($words);

  $camel .= implode('', array_map('ucfirst', $words));

  return $camel;
}
