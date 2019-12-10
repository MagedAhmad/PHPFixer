<?php

namespace PHPFixer;

use Symfony\Component\Finder\Finder;

class Fixer 
{
    protected $finder;
    protected $patterns  = [
        'fixClass', 'fixFunctions'
    ];

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
            $this->fixFile($file);
        }
    }

    public function fixFile($file)
    {
        foreach($this->patterns as $pattern) {
            $contents = $this->read($file);
            $results = $this->$pattern($contents);
    
            file_put_contents($file, $results);
        }
    }

    public function iterateFiles()
    {
        $this->finder->files()->name('*.php')->notName('Fixer.php')->in(__DIR__);
    }

    public function read($fileName)
    {
        if (!file_exists($fileName)) {
            echo 'File doesn\'t exist';
            
            exit;
        }
        echo 'Processing: ' . $fileName . PHP_EOL;

        return file($fileName);
    }

    public function fixClass(array $contents)
    {
        $result = preg_replace_callback_array([
            '!class (.*?)[ ]?{!' =>
            function ($match) {
                return 'class '. trim($match[1]) . PHP_EOL .'{';
            },
        ], $contents);

        
        $results = implode('', $result);
        
        return $results;
    }

    public function fixFunctions(array $contents)
    {
        $result = preg_replace_callback_array([
            '!function(.*?)[ ]?{!' =>
            function ($match) {
                return 'function '. trim($match[1]) . "\n\t{";
            },
        ], $contents);
        $results = implode('', $result);
        
        return $results;
    }
}
