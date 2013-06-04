<?php

namespace Prosperia\Tokn;

interface ITokn
{
    public function getName();
    public function getReference();
    public function read();
    public function write();
}