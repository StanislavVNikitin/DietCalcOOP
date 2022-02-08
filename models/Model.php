<?php

namespace app\models;


abstract class Model
{
    protected $keyFieldName = 'id';
    protected $props = [];
    protected $protectedProps = [];

    public function __set($name, $value)
    {
        /*  if (!isset($this->props[$name])){
            $this->props[$name] = true;
            $this->$name = $value;
        }*/
        if (
            array_key_exists($name, $this->props) &&
            $value != $this->$name &&
            array_search($name, $this->protectedProps) === false
        ) {
            $this->props[$name] = true;
            $this->$name = $value;
        }

    }

    public function __get($name)
    {
        //TODO Проверить по props можно ли вообще читать это поле
        return $this->$name;
    }

    public function __isset($name) {
        //TODO проверить существует ли поле и вернуть bool
        return true;
    }

}