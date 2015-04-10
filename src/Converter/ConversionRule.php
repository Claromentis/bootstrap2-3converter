<?php
namespace Converter;

abstract class ConversionRule
{
    public $is_modified = false;
    public $is_notable = false;

    public function run() {  /* noop */ }
}