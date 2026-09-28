<?php

namespace Google\CustomOperation;

interface CustomOperationWithErrorAnnotations
{
    public function isThisOperationDoneOrWhat();
    public function getTheErrorCode();
    public function getTheErrorMessage();
}
