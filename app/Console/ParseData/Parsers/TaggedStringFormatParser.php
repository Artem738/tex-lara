<?php

namespace App\Console\ParseData\Parsers;

use App\Helpers\MyHelper;
use App\Helpers\StringHelper;

class TaggedStringFormatParser extends AbstractParser
{
    public function do(string $content): void
    {
        $content = MyHelper::parseContMulti($content, $this->charStart, $this->charEnd);
        $content = StringHelper::parseTaggedString($content);
        $this->result = StringHelper::formatPurposeString($content);
    }
}
