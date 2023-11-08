<?php

namespace App\Console\ParseData\Parsers;

interface IItemParser
{
    public function parse(string $content): string;

    public function __toString(): string;
}
