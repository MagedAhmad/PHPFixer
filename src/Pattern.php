<?php

namespace PHPFixer;

class Pattern 
{
    protected $reader;
    protected $patterns  = [
        'fixClass', 'fixFunctions'
    ];
    
    public function __construct()
    {
        $this->reader = new Reader;    
    }

    public function check(string $file)
    {
        foreach($this->patterns as $pattern) {
            $contents = $this->reader->read($file);
            $results = $this->$pattern($contents);
    
            file_put_contents($file, $results);
        }

        echo 'Processing: ' . $file . PHP_EOL;
    }

    public function fixClass(array $contents)
    {
        $result = preg_replace_callback_array([
            '!class (.*?)[ ]?{!' =>
            function ($match) {
                return 'class '. trim($match[1]) . PHP_EOL .'{';
            },
        ], $contents);
        
        return implode('', $result);
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
