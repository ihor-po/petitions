<?php

namespace Framework;

abstract class Controller
{
    public function __construct()
    {
        $this->before();
    }
    public function __destruct()
    {
        $this->after();
    }
    protected function before()
    {
        // code
    }
    protected function after()
    {
        // code
    }
}