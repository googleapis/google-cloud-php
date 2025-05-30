<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1\BackendService;

use UnexpectedValueException;

/**
 * Type of session affinity to use. The default is NONE. Only NONE and HEADER_FIELD are supported when the backend service is referenced by a URL map that is bound to target gRPC proxy that has validateForProxyless field set to true. For more details, see: [Session Affinity](https://cloud.google.com/load-balancing/docs/backend-service#session_affinity). sessionAffinity cannot be specified with haPolicy.
 *
 * Protobuf type <code>google.cloud.compute.v1.BackendService.SessionAffinity</code>
 */
class SessionAffinity
{
    /**
     * A value indicating that the enum field is not set.
     *
     * Generated from protobuf enum <code>UNDEFINED_SESSION_AFFINITY = 0;</code>
     */
    const UNDEFINED_SESSION_AFFINITY = 0;
    /**
     * 2-tuple hash on packet's source and destination IP addresses. Connections from the same source IP address to the same destination IP address will be served by the same backend VM while that VM remains healthy.
     *
     * Generated from protobuf enum <code>CLIENT_IP = 345665051;</code>
     */
    const CLIENT_IP = 345665051;
    /**
     * 1-tuple hash only on packet's source IP address. Connections from the same source IP address will be served by the same backend VM while that VM remains healthy. This option can only be used for Internal TCP/UDP Load Balancing.
     *
     * Generated from protobuf enum <code>CLIENT_IP_NO_DESTINATION = 106122516;</code>
     */
    const CLIENT_IP_NO_DESTINATION = 106122516;
    /**
     * 5-tuple hash on packet's source and destination IP addresses, IP protocol, and source and destination ports. Connections for the same IP protocol from the same source IP address and port to the same destination IP address and port will be served by the same backend VM while that VM remains healthy. This option cannot be used for HTTP(S) load balancing.
     *
     * Generated from protobuf enum <code>CLIENT_IP_PORT_PROTO = 221722926;</code>
     */
    const CLIENT_IP_PORT_PROTO = 221722926;
    /**
     * 3-tuple hash on packet's source and destination IP addresses, and IP protocol. Connections for the same IP protocol from the same source IP address to the same destination IP address will be served by the same backend VM while that VM remains healthy. This option cannot be used for HTTP(S) load balancing.
     *
     * Generated from protobuf enum <code>CLIENT_IP_PROTO = 25322148;</code>
     */
    const CLIENT_IP_PROTO = 25322148;
    /**
     * Hash based on a cookie generated by the L7 loadbalancer. Only valid for HTTP(S) load balancing.
     *
     * Generated from protobuf enum <code>GENERATED_COOKIE = 370321204;</code>
     */
    const GENERATED_COOKIE = 370321204;
    /**
     * The hash is based on a user specified header field.
     *
     * Generated from protobuf enum <code>HEADER_FIELD = 200737960;</code>
     */
    const HEADER_FIELD = 200737960;
    /**
     * The hash is based on a user provided cookie.
     *
     * Generated from protobuf enum <code>HTTP_COOKIE = 494981627;</code>
     */
    const HTTP_COOKIE = 494981627;
    /**
     * No session affinity. Connections from the same client IP may go to any instance in the pool.
     *
     * Generated from protobuf enum <code>NONE = 2402104;</code>
     */
    const NONE = 2402104;
    /**
     * Strong cookie-based affinity. Connections bearing the same cookie will be served by the same backend VM while that VM remains healthy, as long as the cookie has not expired.
     *
     * Generated from protobuf enum <code>STRONG_COOKIE_AFFINITY = 438628091;</code>
     */
    const STRONG_COOKIE_AFFINITY = 438628091;

    private static $valueToName = [
        self::UNDEFINED_SESSION_AFFINITY => 'UNDEFINED_SESSION_AFFINITY',
        self::CLIENT_IP => 'CLIENT_IP',
        self::CLIENT_IP_NO_DESTINATION => 'CLIENT_IP_NO_DESTINATION',
        self::CLIENT_IP_PORT_PROTO => 'CLIENT_IP_PORT_PROTO',
        self::CLIENT_IP_PROTO => 'CLIENT_IP_PROTO',
        self::GENERATED_COOKIE => 'GENERATED_COOKIE',
        self::HEADER_FIELD => 'HEADER_FIELD',
        self::HTTP_COOKIE => 'HTTP_COOKIE',
        self::NONE => 'NONE',
        self::STRONG_COOKIE_AFFINITY => 'STRONG_COOKIE_AFFINITY',
    ];

    public static function name($value)
    {
        if (!isset(self::$valueToName[$value])) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no name defined for value %s', __CLASS__, $value));
        }
        return self::$valueToName[$value];
    }


    public static function value($name)
    {
        $const = __CLASS__ . '::' . strtoupper($name);
        if (!defined($const)) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no value defined for name %s', __CLASS__, $name));
        }
        return constant($const);
    }
}


