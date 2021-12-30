<?php

namespace Nta\AuthOtp\Supports;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

abstract class BaseMakeCommand
{

    /**
     * @param mixed $moduleName
     *
     * @return string
     */
    public function buildContentStub($moduleName)
    {
        $stub = File::get($this->getStub());
        return $this->handleReplacements($stub, $moduleName);
    }

    /**
     * @param mixed $stub
     * @param mixed $moduleName
     *
     * @return string
     */
    protected function handleReplacements($stub, $moduleName)
    {
        $replacements = $this->baseReplacements($moduleName);
        $moduleString = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $stub
        );
        return $moduleString;
    }

    /**
     * @param string $replaceText
     * @return array
     */
    public function baseReplacements(string $replaceText)
    {
        return [
            '{Module}' => Str::studly($replaceText),
            '{modules}' => Str::plural(Str::slug(strtolower($replaceText), '_')),
            '{Modules}' => Str::plural(Str::studly($replaceText)),
        ];
    }

    /**
     * Get file stub
     * @return string
     */
    abstract public function getStub();
}
