<?php

namespace Google\Cloud\Storage;

function registerStreamWrapper(string $protocol = null)
{
    $protocol = $protocol ?: 'gs';
    if (!in_array($protocol, stream_get_wrappers())) {
        stream_wrapper_register($protocol, StreamWrapper::class)
            or throw new RuntimeException("Failed to register '$protocol://' protocol");
    }
}

function unregisterStreamWrapper(string $protocol = null)
{
    stream_wrapper_unregister($protocol ?: 'gs');
}
