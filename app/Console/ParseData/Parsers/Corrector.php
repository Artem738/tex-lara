<?php

namespace App\Console\ParseData\Parsers;

class Corrector
{
    /**
     * @var \Closure[]
     */
    protected array $callbacks = [];
    public function __construct(protected array $rules = [], ?\Closure $postHandler = null, protected ?\Closure $preHandler = null) {
        if (!is_null($postHandler)) {
            $this->addCallback($postHandler);
        }
    }

    public function replace(string $content): string
    {
        if (!is_null($this->preHandler)) {
            $f = $this->preHandler;
            $f($content);
        }
        foreach ($this->rules as $find => $replace) {
            $content = str_replace($find, $replace, $content);
        }

        foreach ($this->callbacks as $callback) {
            $content = $callback($content);
        }
        return $content;
    }

    public function addCallback(\Closure $callback): void
    {
        $this->callbacks[] = $callback;
    }
}
