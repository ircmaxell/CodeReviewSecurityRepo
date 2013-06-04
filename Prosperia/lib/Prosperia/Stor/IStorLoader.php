<?php

namespace Prosperia\Stor;

interface IStorLoader
{
    public function fetch();
    public function load();
}