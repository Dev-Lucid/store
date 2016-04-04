<?php
namespace Lucid\Component\Store;

interface StoreInterface
{
    public function setSource(&$source);
    public function is_set(string $property);
    public function un_set(string $property);
    public function get(string $property, $defaultValue);
    public function set(string $property, $defaultValue, $additionalParameter=null);
    public function string(string $property, $defaultValue);
    public function int(string $property, $defaultValue);
    public function integer(string $property, $defaultValue);
    public function float(string $property, $defaultValue);
    public function bool(string $property, $defaultValue, $allowStringOn, $allowStringTrue, $allowString1);
    public function boolean(string $property, $defaultValue, $allowStringOn, $allowStringTrue, $allowString1);
    public function DateTime(string $property, $defaultValue);
    public function setValues(array $array);
}
