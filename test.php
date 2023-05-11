<?php


class Foo
{

    public $var1 = 2;
    public $var2 = 3;
    public function firstfunc()
    {
        echo 'hello ';
        return $this->var1;
    }

    public function secondfunc()
    {
        echo 'world';
        return $this -> var2;
    }
}

$obj = new Foo();
$obj->firstfunc()->secondfunc();




