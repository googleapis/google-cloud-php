<?php

// Defines links to external types not defined within the library.
// Each element must contain `name` and `uri` keys and may contain `depName`
// and `strip`.
//
// Name should be a fully-qualified name, or a base namespace.
// URIs may be direct links, or URI templates.
// If a URI template, `type` and `depVersion` are available replacements.
// URI templates are only used when `depName` key is provided. `depName` must
// correspond to a dependency provided in composer.json and currently installed.
// `strip` key will remove the dependency name from the type. This is useful for
// fixing non-PSR-4 conformant types.
//
// Please order types alphabetically under the appropriate heading.

return [

  // native and pseudo-types
  [
    "name" => "array",
    "uri" => "http://php.net/manual/en/language.types.array.php"
  ], [
    "name" => "bool",
    "uri" => "http://php.net/manual/en/language.types.boolean.php"
  ], [
    "name" => "Boolean",
    "uri" => "http://php.net/manual/en/language.types.boolean.php"
  ], [
    "name" => "callable",
    "uri" => "http://php.net/manual/en/language.types.callable.php"
  ], [
    "name" => "float",
    "uri" => "http://php.net/manual/en/language.types.float.php"
  ], [
    "name" => "int",
    "uri" => "http://php.net/manual/en/language.types.integer.php"
  ], [
    "name" => "mixed",
    "uri" => "http://php.net/manual/en/language.pseudo-types.php#language.types.mixed"
  ], [
    "name" => "null",
    "uri" => "http://php.net/manual/en/language.types.null.php"
  ], [
    "name" => "resource",
    "uri" => "http://php.net/manual/en/language.types.resource.php"
  ], [
    "name" => "string",
    "uri" => "http://php.net/manual/en/language.types.string.php"
  ], [
    "name" => "void",
    "uri" => "http://php.net/manual/en/language.pseudo-types.php#language.types.void"
  ],

  // PHP native classes
  [
    "name" => "ArrayAccess",
    "uri" => "https://php.net/arrayaccess"
  ], [
    "name" => "Countable",
    "uri" => "https://php.net/countable"
  ], [
    "name" => "DateTimeInterface",
    "uri" => "http://php.net/manual/en/class.datetimeinterface.php"
  ], [
    "name" => "Exception",
    "uri" => "http://php.net/manual/en/class.exception.php"
  ], [
    "name" => "Generator",
    "uri" => "http://php.net/manual/en/class.generator.php"
  ], [
    "name" => "Iterator",
    "uri" => "http://php.net/manual/en/class.iterator.php"
  ], [
    "name" => "JsonSerializable",
    "uri" => "http://php.net/manual/en/class.jsonserializable.php"
  ], [
    "name" => "Reflector",
    "uri" => "https://php.net/reflector"
  ], [
    "name" => "Traversable",
    "uri" => "http://php.net/manual/en/class.traversable.php"
  ],

  // Dependency types
  [
    "name" => "Google\\ApiCore\\",
    "uri" => "https://googleapis.github.io/gax-php/{depVersion}{/type*}.html",
    "depName" => "google/gax"
  ], [
    "name" => "Google\\Auth\\",
    "uri" => "https://github.com/googleapis/google-auth-library-php/tree/{depVersion}/src{/type*}.php",
    "depName" => "google/auth",
    "strip" => true
  ], [
    "name" => "Google\\Api\\",
    "uri" => "https://googleapis.github.io/gax-php/{depVersion}{/type*}.html",
    "depName" => "google/gax"
  ], [
    "name" => "Google\\Cloud\\",
    "uri" => "https://googleapis.github.io/gax-php/{depVersion}{/type*}.html",
    "depName" => "google/gax"
  ], [
    "name" => "Google\\LongRunning\\",
    "uri" => "https://googleapis.github.io/gax-php/{depVersion}{/type*}.html",
    "depName" => "google/gax"
  ], [
    "name" => "Google\\Protobuf\\",
    "uri" => "https://github.com/protocolbuffers/protobuf-php/tree/{depVersion}/src{/type*}.php",
    "depName" => "google/protobuf"
  ], [
    "name" => "Google\\Rpc\\",
    "uri" => "https://googleapis.github.io/gax-php/{depVersion}{/type*}.html",
    "depName" => "google/gax"
  ], [
    "name" => "Google\\Type\\",
    "uri" => "https://googleapis.github.io/gax-php/{depVersion}{/type*}.html",
    "depName" => "google/gax"
  ], [
    "name" => "GuzzleHttp\\Promise",
    "uri" => "https://github.com/guzzle/promises/tree/{depVersion}/src{/type*}.php",
    "depName" => "guzzlehttp/promises",
    "strip" => true
  ], [
    "name" => "Psr\\Cache\\",
    "uri" => "https://github.com/php-fig/cache/tree/{depVersion}/src{/type*}.php",
    "depName" => "psr/cache",
    "strip" => true
  ], [
    "name" => "Psr\\Log\\",
    "uri" => "https://github.com/php-fig/log/tree/{depVersion}{/type*}.php",
    "depName" => "psr/log"
  ], [
    "name" => "Psr\\Http\\Message\\",
    "uri" => "https://github.com/php-fig/http-message/tree/{depVersion}/src{/type*}.php",
    "depName" => "psr/http-message",
    "strip" => true
  ]
];
