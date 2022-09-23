<?php

namespace Kenjiefx\StrawberryFramework\App\Services;

class JSImporter
{
    private array $codeBlockChars = [];
    private array $statement = ['/','*','*','@','i','m','p','o','r','t'];

    public function __construct(
        private string $codeBlock,
        private string $componentPath
        )
    {
        $this->codeBlockChars = str_split($codeBlock);
    }

    public function import()
    {
        $isRecording = false;
        $completeRecording = false;
        $recordedStatement = '';
        $statementCharsPointer = 0;
        $statements = [];

        foreach ($this->codeBlockChars as $scriptChar) {
            if ($scriptChar===' ') {
                $recordedStatement .= $scriptChar;
                continue;
            }
            if ($isRecording&&$scriptChar==='*') {
                $completeRecording = true;
                $isRecording = false;
            }
            if ($isRecording) {
                $recordedStatement .= $scriptChar;
            }
            if (
                isset($this->statement[$statementCharsPointer]) &&
                $this->statement[$statementCharsPointer]===$scriptChar &&
                !$completeRecording
            ) {
                $recordedStatement .= $scriptChar;
                $statementCharsPointer++;
            } else {
                $statementCharsPointer = 0;
            }
            if ($statementCharsPointer===10) {
                $isRecording = true;
            }
            if ($completeRecording) {
                array_push($statements,$recordedStatement.'**/');
                $completeRecording = false;
            }
        }

        if (empty($statements)) {
            return $this->codeBlock;
        }

        $codeBlockImport = $this->codeBlock;

        foreach ($statements as $statement) {
            $importStatement = '';
            $statementChars = str_split($statement);
            foreach ($statementChars as $statementChar) {
                if ($statementChar==='/'||$statementChar==='*') continue;
                $importStatement .= $statementChar;
            }
            $importStatement = trim($importStatement);
            [$importKeyword,$importFileName] = explode(' ',$importStatement);
            $path = $this->componentPath.'/'.trim($importFileName).'.js';
            if (file_exists($path)) {
                $contents = file_get_contents($path);
                $codeBlockImport = str_replace($statement,$contents,$codeBlockImport);
            }
        }

        return $codeBlockImport;

    }
}
