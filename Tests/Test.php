<?php

require_once __DIR__ . '/../vendor/autoload.php';

use XLphp\Compiler;

echo "Testing XLphp Compiler...\n\n";

$compiler = new Compiler();

$testCode = <<<XL
print "Hello"
name = "Test"
when name == "Test" {
    print " Passed"
}
func add(a,b) => a + b
result = add(5,3)
print " Result: {result}"
XL;

file_put_contents('test.xlphp', $testCode);

echo "Original XLphp code:\n";
echo $testCode . "\n\n";

echo "Compiled PHP code:\n";
echo $compiler->compileFile('test.xlphp') . "\n";

unlink('test.xlphp');

echo "\nTest completed!\n";
