<?php

namespace Google\CustomOperation;

interface CustomOperationClient
{
    public function getMyOperationPlease($name, $requiredArg1, $requiredArg2);
    public function cancelMyOperationPlease($name, $requiredArg1, $requiredArg2);
    public function deleteMyOperationPlease($name, $requiredArg1, $requiredArg2);
}
