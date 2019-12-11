<?php

namespace PHPFixer;

use Symfony\Component\Finder\Finder;

class Reader
{
    public $finder;

    public function __construct()
    {
        $this->finder = new Finder;
    }

    public function searchForFiles()
    {
        $this->finder->files()->name('*.php')->notName('Pattern.php')->in(__DIR__);
    }

    public function hasFiles()
    {
        return $this->finder->hasResults();
    }

    public function read(string $file)
    {
        if (!file_exists($file)) {
            echo 'File doesn\'t exist';
            
            exit;
        }

        return file($file);
    }
}
