<?php

namespace PHPFixer;

use Symfony\Component\Finder\Finder;

class Fixer 
{
    protected $finder;

    public function __construct()
    {
        $this->finder = new Finder();
    }

    public function run()
    {
        $this->iterateFiles();
        
        if(!$this->finder->hasResults()) {
            return 'No Files to Fix';
        }
        
        foreach($this->finder as $file) {
            $this->scan($file);
        }
    }

    public function iterateFiles()
    {
        $this->finder->files()->in(__DIR__);
    }

    

    public function scan($fileName)
    {
        if (!file_exists($fileName)) {
            echo 'File doesn\'t exist';
            exit;
        }
        $contents = file($fileName);
        echo 'Processing: ' . $fileName . PHP_EOL;
        
        $result = preg_replace_callback_array([
            '!class (.*? )*{!' =>
            function ($match) {
                return 'class '. trim($match[1]) . PHP_EOL .'{';
            },
        ], $contents); 
        $results = implode('', $result);
        file_put_contents($fileName, $result);
        return implode('', $result);
    }
}
