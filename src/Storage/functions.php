<?php

namespace Google\Cloud\Storage;

function registerStreamWrapper(string $protocol = 'gs')
{
    if (!in_array($protocol, stream_get_wrappers())) {
        stream_wrapper_register($protocol, "Google\Cloud\Storage\StreamWrapper")
            or die("Failed to register '$protocol://' protocol");
    }
}

function unregisterStreamWrapper(string $protocol = 'gs')
{
    stream_wrapper_unregister($protocol);
}
