<?php
namespace Lucid\Component\Store;

class Store implements StoreInterface
{
    private $source = null;

    public function __construct(&$source=null)
    {
        if(is_null($source) === true)
        {
            $source = [];
        }
        $this->setSource($source);
    }

    public function setSource(&$newSource)
    {
        $this->source =& $newSource;
        $invalidSourceMessage = 'Source for store must either be an array, or an object whose class implements the ArrayAccess and Iterator interfaces.';
        if (is_array($this->source) === false ) {
            if (is_object($this->source) === true) {
                $classImplements = class_implements($this->source);
                if (in_array('ArrayAccess', $classImplements) === false || in_array('Iterator', $classImplements) === false) {
                    throw new \Exception($invalidSourceMessage);
                }
            } else {
                throw new \Exception($invalidSourceMessage);
            }
        }
        return $this;
    }

    public function is_set(string $property): bool
    {
        return isset($this->source[$property]);
    }

    public function un_set(string $property)
    {
        unset($this->source[$property]);
    }

    public function get(string $name, $defaultValue = null)
    {
        return $this->source[$name] ?? $defaultValue;
    }

    public function set(string $name, $newValue, $additionalParameter=null)
    {
        $this->source[$name] = $newValue;
        return $this;
    }

    public function string(string $name, $defaultValue=null): string
    {
        return strval($this->source[$name] ?? $defaultValue);
    }

    public function int(string $name, $defaultValue=-1): int
    {
        if (isset($this->source[$name]) === true) {
            if (is_numeric($this->source[$name]) === false) {
                #lucid::log()->warning('Data in request \''.$name.'\' was not numeric, but is being cast to a int. This will likely truncate the data to value 0. Are you sure this data should be a int?');
            }
            return intval($this->source[$name]);
        } else {
            return $defaultValue;
        }
    }

    public function integer(string $name, $defaultValue=null): int
    {
        return $this->int($name, $defaultValue);
    }

    public function float(string $name, $defaultValue=null): float
    {
        if (isset($this->source[$name]) === true) {
            if (is_numeric($this->source[$name]) === false) {
                lucid::log()->warning('Data in request \''.$name.'\' was set and not numeric, but is being cast to a float. This will likely truncate the data to value 0. Are you sure this data should be a float?');
            }
            return floatval($this->source[$name]);
        } else {
            return $defaultValue;
        }
    }

    public function bool(string $name, $defaultValue=null, $allowStringOn=true, $allowStringTrue = true, $allowString1 = true): bool
    {
        $val = null;
        if (isset($this->source[$name]) === true) {

            $val = false;
            if ($this->source[$name] === true) {
                $val = true;
            } elseif ($allowStringOn === true && strval($this->source[$name]) === 'on') {
                $val = true;
            } elseif ($allowStringTrue === true && strval($this->source[$name]) === 'true') {
                $val = true;
            } elseif ($allowString1 === true && strval($this->source[$name]) === '1') {
                $val = true;
            }
        }

        if (is_null($val) === true) {
            $val = $defaultValue;
        }

        return $val;
    }

    public function boolean(string $name, $defaultValue=null, $allowStringOn=true, $allowStringTrue = true, $allowString1 = true): bool
    {
        return $this->bool($name, $defaultValue, $allowStringOn, $allowStringTrue, $allowString1);
    }

    public function DateTime(string $name, $defaultValue=null, $allowStringOn=true, $allowStringTrue = true, $allowString1 = true): \DateTime
    {
        $val = null;
        if (isset($this->source[$name]) === true) {
            $val = \DateTime::createFromFormat('Y-m-d H:i', $this->source[$name]);
        }
        return $val;
    }

    public function getArray(): array
    {
        if (is_array($this->source)) {
            return $this->source;
        } else {
            $returnArray = [];
            foreach($this->source as $key=>$value) {
                $returnArray[$key] = $value;
            }
            return $returnArray;
        }
    }

    public function setValues(array $array)
    {
        foreach ($array as $key=>$value) {
            $this->set($key, $value);
        }
        return $this;
    }
}
