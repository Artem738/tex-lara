<?php

namespace App\Console\ParseData\Parsers;

use App\Helpers\MyHelper;
use App\Helpers\StringHelper;

class SimpleStringMultyParser extends AbstractParser
{
    public function do(string $content): void
    {
        $this->result = MyHelper::parseContMulti($content, $this->charStart, $this->charEnd);
    }
}
