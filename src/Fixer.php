<?php

namespace PHPFixer;

use Symfony\Component\Finder\Finder;

class Fixer 
{
    protected $finder;
    protected $pattern;
    protected $reader;

    public function __construct()
    {
        $this->finder = new Finder;
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
