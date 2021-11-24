<?php

namespace MPhpMaster\ZATCA\Tags;

class Company extends \MPhpMaster\ZATCA\Tag
{
    const TAG = 1;

    public function __construct(string $value)
    {
        parent::__construct(static::TAG, $value);
    }
}
