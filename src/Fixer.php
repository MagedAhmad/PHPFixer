<?php

namespace PHPFixer;

class Fixer 
{
    protected $finder;
    protected $pattern;
    protected $reader;

    public function __construct()
    {
        $this->pattern = new Pattern;
        $this->reader = new Reader;
    }

    public function run()
    {
        $this->reader->searchForFiles();

        if(!$this->reader->hasFiles()) {
            echo 'No Files to Fix';
        }
        
        foreach($this->reader->finder as $file) {
            $this->fixFile($file);
        }
    }

    public function fixFile(string $file)
    {
        $this->pattern->check($file);
    }
}
