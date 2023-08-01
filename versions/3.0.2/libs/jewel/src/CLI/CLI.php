<?php
    namespace Jewel\CLI;
    use Jewel\Compiler;

    define('JEWEL_CLI', true);
    require('src/Requires/Requires.php');

    if(count($argv) < 3) {
        echo "jewel requires arguments <filename> and <outfile>";
        exit();
    }

    $compiler = new Compiler;
    $compiler->Run(
        realpath(getcwd() . '/' . $argv[1]), 
        getcwd() . '/' . $argv[2]
    );