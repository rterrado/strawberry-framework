<?php

namespace Kenjiefx\StrawberryFramework\App\Services;

class JSMinifier
{
    private int|null $firstBracketPos = null;
    private int|null $lastBrackPos = null;
    private array $codeBlockChars = [];
    private string $funcHead = '';

    public function __construct(
        private string $codeBlock
        )
    {
        $this->codeBlockChars = str_split($codeBlock);
        $this->locBrkt();
        $this->setFuncHead();
    }

    private function locBrkt()
    {
        $i = 0;
        foreach ($this->codeBlockChars as $scriptChar) {
            if ($scriptChar==='{'&&null===$this->firstBracketPos)
                $this->firstBracketPos = $i+1;
            if ($scriptChar==='}')
                $this->lastBrackPos = $i;
            $i++;
        }
        $this->lastBrackPos = $this->lastBrackPos - $i;
    }

    private function setFuncHead()
    {
        $this->funcHead = substr(
            $this->codeBlock,0,$this->firstBracketPos
        );
    }

    public function minify()
    {
        $minified = substr(
            $this->codeBlock,
            $this->firstBracketPos ?? 0,
            $this->lastBrackPos
        );

        return $this->reconstruct(
            \JShrink\Minifier::minify($minified)
        );
    }

    private function reconstruct(
        string $minified
        )
    {
        return $this->funcHead.$minified.'}); ';
    }
}
