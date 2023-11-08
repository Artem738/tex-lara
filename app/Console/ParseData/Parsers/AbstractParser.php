<?php

namespace App\Console\ParseData\Parsers;

use App\Helpers\MyHelper;
use App\Helpers\StringHelper;

abstract class AbstractParser implements IItemParser
{
    protected string $result = '';
    public function __construct(protected string $charStart, protected string $charEnd, protected ?Corrector $corrector = null) { }

    abstract protected function do(string $content): void;

    public function parse(string $content): string
    {
        $this->do($content);
        if (!is_null($this->corrector)) {
            $this->result = $this->corrector->replace($this->result);
        }
        return $this->result;
    }

    public function __toString(): string
    {
        return $this->result;
    }

}
