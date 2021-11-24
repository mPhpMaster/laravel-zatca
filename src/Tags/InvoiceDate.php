<?php

namespace MPhpMaster\ZATCA\Tags;

class InvoiceDate extends \MPhpMaster\ZATCA\Tag
{
    const TAG = 3;

    public function __construct(string $value)
    {
        parent::__construct(static::TAG, $value);
    }
}
