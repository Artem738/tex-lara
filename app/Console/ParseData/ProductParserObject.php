<?php

namespace App\Console\ParseData;

use App\Console\ParseData\Parsers\IItemParser;

class ProductParserObject
{
    const PARSER_DIR = __DIR__ . '/../../../config/parsing/parsing_plan.php';
    /**
     * @var IItemParser[]
     */
    protected array $parsers = [];


    public function __construct(public string $r, public string $goodUrl)
    {
        $this->loadParsers();
        $this->parseProductPage();
    }

    protected function loadParsers(): void
    {
        $this->parsers = require_once static::PARSER_DIR;
    }

    public function parseProductPage(): void
    {
        foreach ($this->parsers as $key => $parser) {
            $parser->parse($this->r);
        }
    }

    public function __toString()
    {
        $reset = "\033[0m"; // Сброс стилей
        $result = $this->getColorString($this->goodUrl, "Good URL");
        foreach ($this->parsers as $key => $parser) {
            $result .= $this->getColorString($parser, rtrim($key));
        }
        return $result . $reset;
    }

    private function getColorString(string $value, string $label): string
    {
        $reset = "\033[0m";  // Сброс стилей
        $red = "\033[31m";   // Красный
        $green = "\033[32m"; // Зеленый

        $color = $red; // По умолчанию красный
        if (!empty($value)) {
            $color = $green; // Зеленый, если значение не пустое и не равно нулю
        }

        return $color . $label . ": " . $reset . $color . $value . "\n";
    }
}
