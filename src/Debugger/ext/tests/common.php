<?php
echo "executing...\n\n\n\n\n";
// $foo = 'bar';
// $asdf = ['qwer', 5, 20.1];
//
function foo($val) {
    $x = 1;
    stackdriver_debugger('123');
    return $val;
}
//
function loop($times)
{
    $sum = 0;
    for ($i = 0; $i < $times; $i++) {
        $sum += $i;//foo($i);
    }
    return $sum;
}

loop(3);
// foo(3);
// stackdriver_debugger("1234");

// echo 'foo' . PHP_EOL;
//
// class FooBar {
//     function asdf() {
//         return 'asdf';
//     }
// }
