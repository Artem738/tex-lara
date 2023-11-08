<?php

namespace App\Console\ParseData\Parsers;


class NullStringParser extends AbstractParser
{
    public function do(string $content): void
    {
        $this->result = $content;
    }
}
