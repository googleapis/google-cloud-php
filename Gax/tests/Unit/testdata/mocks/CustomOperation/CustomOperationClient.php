<?php

namespace Google\CustomOperation;

interface CustomOperationClient
{
    public function getMyOperationPlease($request);
    public function cancelMyOperationPlease($request);
    public function deleteMyOperationPlease($request);
}
