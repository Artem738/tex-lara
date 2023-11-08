<?php

namespace App\Console\ParseData\Parsers;

use App\Helpers\MyHelper;
use App\Helpers\StringHelper;

class TaggedStringParser extends AbstractParser
{
    public function do(string $content): void
    {
        $content = MyHelper::parseContMulti($content, $this->charStart, $this->charEnd);
        $this->result = StringHelper::parseTaggedString($content);
    }
}
