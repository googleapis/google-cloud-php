<?php

// "Client" in the namespace tells OperationResponse that this is a new surface client
namespace Google\ApiCore\Tests\Unit\Client;

class NewSurfaceCustomOperationClient
{
    public function getNewSurfaceOperation(GetOperationRequest $request, array $callOptions = [])
    {

    }

    public function cancelNewSurfaceOperation(CancelOperationRequest $request, array $callOptions = [])
    {

    }

    public function deleteNewSurfaceOperation(DeleteOperationRequest $request, array $callOptions = [])
    {

    }
}

abstract class BaseOperationRequest
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

class GetOperationRequest extends BaseOperationRequest
{
}

class CancelOperationRequest extends BaseOperationRequest
{
}

class DeleteOperationRequest extends BaseOperationRequest
{
}
