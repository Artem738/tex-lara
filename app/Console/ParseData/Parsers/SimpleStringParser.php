<?php

namespace App\Console\ParseData\Parsers;

use App\Helpers\MyHelper;
use App\Helpers\StringHelper;

class SimpleStringParser extends AbstractParser
{
    public function do(string $content): void
    {
        $content = MyHelper::parseCont($content, $this->charStart, $this->charEnd)[0] ?? '';
        $this->result = StringHelper::megaTrim($content);
    }
}
