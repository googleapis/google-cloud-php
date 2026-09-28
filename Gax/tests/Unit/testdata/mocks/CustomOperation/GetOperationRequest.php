<?php

namespace Google\CustomOperation;

class GetOperationRequest
{
    public string $name;
    public string $arg2;
    public string $arg3;

    public static function build(string $arg2, string $arg3, string $name): static
    {
        $request = new static();
        $request->name = $name;
        $request->arg2 = $arg2;
        $request->arg3 = $arg3;

        return $request;
    }
}
