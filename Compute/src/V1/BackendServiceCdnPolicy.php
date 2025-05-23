<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Message containing Cloud CDN configuration for a backend service.
 *
 * Generated from protobuf message <code>google.cloud.compute.v1.BackendServiceCdnPolicy</code>
 */
class BackendServiceCdnPolicy extends \Google\Protobuf\Internal\Message
{
    /**
     * Bypass the cache when the specified request headers are matched - e.g. Pragma or Authorization headers. Up to 5 headers can be specified. The cache is bypassed for all cdnPolicy.cacheMode settings.
     *
     * Generated from protobuf field <code>repeated .google.cloud.compute.v1.BackendServiceCdnPolicyBypassCacheOnRequestHeader bypass_cache_on_request_headers = 486203082;</code>
     */
    private $bypass_cache_on_request_headers;
    /**
     * The CacheKeyPolicy for this CdnPolicy.
     *
     * Generated from protobuf field <code>optional .google.cloud.compute.v1.CacheKeyPolicy cache_key_policy = 159263727;</code>
     */
    private $cache_key_policy = null;
    /**
     * Specifies the cache setting for all responses from this backend. The possible values are: USE_ORIGIN_HEADERS Requires the origin to set valid caching headers to cache content. Responses without these headers will not be cached at Google's edge, and will require a full trip to the origin on every request, potentially impacting performance and increasing load on the origin server. FORCE_CACHE_ALL Cache all content, ignoring any "private", "no-store" or "no-cache" directives in Cache-Control response headers. Warning: this may result in Cloud CDN caching private, per-user (user identifiable) content. CACHE_ALL_STATIC Automatically cache static content, including common image formats, media (video and audio), and web assets (JavaScript and CSS). Requests and responses that are marked as uncacheable, as well as dynamic content (including HTML), will not be cached. If no value is provided for cdnPolicy.cacheMode, it defaults to CACHE_ALL_STATIC.
     * Check the CacheMode enum for the list of possible values.
     *
     * Generated from protobuf field <code>optional string cache_mode = 28877888;</code>
     */
    private $cache_mode = null;
    /**
     * Specifies a separate client (e.g. browser client) maximum TTL. This is used to clamp the max-age (or Expires) value sent to the client. With FORCE_CACHE_ALL, the lesser of client_ttl and default_ttl is used for the response max-age directive, along with a "public" directive. For cacheable content in CACHE_ALL_STATIC mode, client_ttl clamps the max-age from the origin (if specified), or else sets the response max-age directive to the lesser of the client_ttl and default_ttl, and also ensures a "public" cache-control directive is present. If a client TTL is not specified, a default value (1 hour) will be used. The maximum allowed value is 31,622,400s (1 year).
     *
     * Generated from protobuf field <code>optional int32 client_ttl = 29034360;</code>
     */
    private $client_ttl = null;
    /**
     * Specifies the default TTL for cached content served by this origin for responses that do not have an existing valid TTL (max-age or s-maxage). Setting a TTL of "0" means "always revalidate". The value of defaultTTL cannot be set to a value greater than that of maxTTL, but can be equal. When the cacheMode is set to FORCE_CACHE_ALL, the defaultTTL will overwrite the TTL set in all responses. The maximum allowed value is 31,622,400s (1 year), noting that infrequently accessed objects may be evicted from the cache before the defined TTL.
     *
     * Generated from protobuf field <code>optional int32 default_ttl = 100253422;</code>
     */
    private $default_ttl = null;
    /**
     * Specifies the maximum allowed TTL for cached content served by this origin. Cache directives that attempt to set a max-age or s-maxage higher than this, or an Expires header more than maxTTL seconds in the future will be capped at the value of maxTTL, as if it were the value of an s-maxage Cache-Control directive. Headers sent to the client will not be modified. Setting a TTL of "0" means "always revalidate". The maximum allowed value is 31,622,400s (1 year), noting that infrequently accessed objects may be evicted from the cache before the defined TTL.
     *
     * Generated from protobuf field <code>optional int32 max_ttl = 307578001;</code>
     */
    private $max_ttl = null;
    /**
     * Negative caching allows per-status code TTLs to be set, in order to apply fine-grained caching for common errors or redirects. This can reduce the load on your origin and improve end-user experience by reducing response latency. When the cache mode is set to CACHE_ALL_STATIC or USE_ORIGIN_HEADERS, negative caching applies to responses with the specified response code that lack any Cache-Control, Expires, or Pragma: no-cache directives. When the cache mode is set to FORCE_CACHE_ALL, negative caching applies to all responses with the specified response code, and override any caching headers. By default, Cloud CDN will apply the following default TTLs to these status codes: HTTP 300 (Multiple Choice), 301, 308 (Permanent Redirects): 10m HTTP 404 (Not Found), 410 (Gone), 451 (Unavailable For Legal Reasons): 120s HTTP 405 (Method Not Found), 421 (Misdirected Request), 501 (Not Implemented): 60s. These defaults can be overridden in negative_caching_policy.
     *
     * Generated from protobuf field <code>optional bool negative_caching = 336110005;</code>
     */
    private $negative_caching = null;
    /**
     * Sets a cache TTL for the specified HTTP status code. negative_caching must be enabled to configure negative_caching_policy. Omitting the policy and leaving negative_caching enabled will use Cloud CDN's default cache TTLs. Note that when specifying an explicit negative_caching_policy, you should take care to specify a cache TTL for all response codes that you wish to cache. Cloud CDN will not apply any default negative caching when a policy exists.
     *
     * Generated from protobuf field <code>repeated .google.cloud.compute.v1.BackendServiceCdnPolicyNegativeCachingPolicy negative_caching_policy = 155359996;</code>
     */
    private $negative_caching_policy;
    /**
     * If true then Cloud CDN will combine multiple concurrent cache fill requests into a small number of requests to the origin.
     *
     * Generated from protobuf field <code>optional bool request_coalescing = 532808276;</code>
     */
    private $request_coalescing = null;
    /**
     * Serve existing content from the cache (if available) when revalidating content with the origin, or when an error is encountered when refreshing the cache. This setting defines the default "max-stale" duration for any cached responses that do not specify a max-stale directive. Stale responses that exceed the TTL configured here will not be served. The default limit (max-stale) is 86400s (1 day), which will allow stale content to be served up to this limit beyond the max-age (or s-maxage) of a cached response. The maximum allowed value is 604800 (1 week). Set this to zero (0) to disable serve-while-stale.
     *
     * Generated from protobuf field <code>optional int32 serve_while_stale = 236682203;</code>
     */
    private $serve_while_stale = null;
    /**
     * Maximum number of seconds the response to a signed URL request will be considered fresh. After this time period, the response will be revalidated before being served. Defaults to 1hr (3600s). When serving responses to signed URL requests, Cloud CDN will internally behave as though all responses from this backend had a "Cache-Control: public, max-age=[TTL]" header, regardless of any existing Cache-Control header. The actual headers served in responses will not be altered.
     *
     * Generated from protobuf field <code>optional int64 signed_url_cache_max_age_sec = 269374534;</code>
     */
    private $signed_url_cache_max_age_sec = null;
    /**
     * [Output Only] Names of the keys for signing request URLs.
     *
     * Generated from protobuf field <code>repeated string signed_url_key_names = 371848885;</code>
     */
    private $signed_url_key_names;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\Compute\V1\BackendServiceCdnPolicyBypassCacheOnRequestHeader>|\Google\Protobuf\Internal\RepeatedField $bypass_cache_on_request_headers
     *           Bypass the cache when the specified request headers are matched - e.g. Pragma or Authorization headers. Up to 5 headers can be specified. The cache is bypassed for all cdnPolicy.cacheMode settings.
     *     @type \Google\Cloud\Compute\V1\CacheKeyPolicy $cache_key_policy
     *           The CacheKeyPolicy for this CdnPolicy.
     *     @type string $cache_mode
     *           Specifies the cache setting for all responses from this backend. The possible values are: USE_ORIGIN_HEADERS Requires the origin to set valid caching headers to cache content. Responses without these headers will not be cached at Google's edge, and will require a full trip to the origin on every request, potentially impacting performance and increasing load on the origin server. FORCE_CACHE_ALL Cache all content, ignoring any "private", "no-store" or "no-cache" directives in Cache-Control response headers. Warning: this may result in Cloud CDN caching private, per-user (user identifiable) content. CACHE_ALL_STATIC Automatically cache static content, including common image formats, media (video and audio), and web assets (JavaScript and CSS). Requests and responses that are marked as uncacheable, as well as dynamic content (including HTML), will not be cached. If no value is provided for cdnPolicy.cacheMode, it defaults to CACHE_ALL_STATIC.
     *           Check the CacheMode enum for the list of possible values.
     *     @type int $client_ttl
     *           Specifies a separate client (e.g. browser client) maximum TTL. This is used to clamp the max-age (or Expires) value sent to the client. With FORCE_CACHE_ALL, the lesser of client_ttl and default_ttl is used for the response max-age directive, along with a "public" directive. For cacheable content in CACHE_ALL_STATIC mode, client_ttl clamps the max-age from the origin (if specified), or else sets the response max-age directive to the lesser of the client_ttl and default_ttl, and also ensures a "public" cache-control directive is present. If a client TTL is not specified, a default value (1 hour) will be used. The maximum allowed value is 31,622,400s (1 year).
     *     @type int $default_ttl
     *           Specifies the default TTL for cached content served by this origin for responses that do not have an existing valid TTL (max-age or s-maxage). Setting a TTL of "0" means "always revalidate". The value of defaultTTL cannot be set to a value greater than that of maxTTL, but can be equal. When the cacheMode is set to FORCE_CACHE_ALL, the defaultTTL will overwrite the TTL set in all responses. The maximum allowed value is 31,622,400s (1 year), noting that infrequently accessed objects may be evicted from the cache before the defined TTL.
     *     @type int $max_ttl
     *           Specifies the maximum allowed TTL for cached content served by this origin. Cache directives that attempt to set a max-age or s-maxage higher than this, or an Expires header more than maxTTL seconds in the future will be capped at the value of maxTTL, as if it were the value of an s-maxage Cache-Control directive. Headers sent to the client will not be modified. Setting a TTL of "0" means "always revalidate". The maximum allowed value is 31,622,400s (1 year), noting that infrequently accessed objects may be evicted from the cache before the defined TTL.
     *     @type bool $negative_caching
     *           Negative caching allows per-status code TTLs to be set, in order to apply fine-grained caching for common errors or redirects. This can reduce the load on your origin and improve end-user experience by reducing response latency. When the cache mode is set to CACHE_ALL_STATIC or USE_ORIGIN_HEADERS, negative caching applies to responses with the specified response code that lack any Cache-Control, Expires, or Pragma: no-cache directives. When the cache mode is set to FORCE_CACHE_ALL, negative caching applies to all responses with the specified response code, and override any caching headers. By default, Cloud CDN will apply the following default TTLs to these status codes: HTTP 300 (Multiple Choice), 301, 308 (Permanent Redirects): 10m HTTP 404 (Not Found), 410 (Gone), 451 (Unavailable For Legal Reasons): 120s HTTP 405 (Method Not Found), 421 (Misdirected Request), 501 (Not Implemented): 60s. These defaults can be overridden in negative_caching_policy.
     *     @type array<\Google\Cloud\Compute\V1\BackendServiceCdnPolicyNegativeCachingPolicy>|\Google\Protobuf\Internal\RepeatedField $negative_caching_policy
     *           Sets a cache TTL for the specified HTTP status code. negative_caching must be enabled to configure negative_caching_policy. Omitting the policy and leaving negative_caching enabled will use Cloud CDN's default cache TTLs. Note that when specifying an explicit negative_caching_policy, you should take care to specify a cache TTL for all response codes that you wish to cache. Cloud CDN will not apply any default negative caching when a policy exists.
     *     @type bool $request_coalescing
     *           If true then Cloud CDN will combine multiple concurrent cache fill requests into a small number of requests to the origin.
     *     @type int $serve_while_stale
     *           Serve existing content from the cache (if available) when revalidating content with the origin, or when an error is encountered when refreshing the cache. This setting defines the default "max-stale" duration for any cached responses that do not specify a max-stale directive. Stale responses that exceed the TTL configured here will not be served. The default limit (max-stale) is 86400s (1 day), which will allow stale content to be served up to this limit beyond the max-age (or s-maxage) of a cached response. The maximum allowed value is 604800 (1 week). Set this to zero (0) to disable serve-while-stale.
     *     @type int|string $signed_url_cache_max_age_sec
     *           Maximum number of seconds the response to a signed URL request will be considered fresh. After this time period, the response will be revalidated before being served. Defaults to 1hr (3600s). When serving responses to signed URL requests, Cloud CDN will internally behave as though all responses from this backend had a "Cache-Control: public, max-age=[TTL]" header, regardless of any existing Cache-Control header. The actual headers served in responses will not be altered.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $signed_url_key_names
     *           [Output Only] Names of the keys for signing request URLs.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Compute\V1\Compute::initOnce();
        parent::__construct($data);
    }

    /**
     * Bypass the cache when the specified request headers are matched - e.g. Pragma or Authorization headers. Up to 5 headers can be specified. The cache is bypassed for all cdnPolicy.cacheMode settings.
     *
     * Generated from protobuf field <code>repeated .google.cloud.compute.v1.BackendServiceCdnPolicyBypassCacheOnRequestHeader bypass_cache_on_request_headers = 486203082;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getBypassCacheOnRequestHeaders()
    {
        return $this->bypass_cache_on_request_headers;
    }

    /**
     * Bypass the cache when the specified request headers are matched - e.g. Pragma or Authorization headers. Up to 5 headers can be specified. The cache is bypassed for all cdnPolicy.cacheMode settings.
     *
     * Generated from protobuf field <code>repeated .google.cloud.compute.v1.BackendServiceCdnPolicyBypassCacheOnRequestHeader bypass_cache_on_request_headers = 486203082;</code>
     * @param array<\Google\Cloud\Compute\V1\BackendServiceCdnPolicyBypassCacheOnRequestHeader>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setBypassCacheOnRequestHeaders($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Compute\V1\BackendServiceCdnPolicyBypassCacheOnRequestHeader::class);
        $this->bypass_cache_on_request_headers = $arr;

        return $this;
    }

    /**
     * The CacheKeyPolicy for this CdnPolicy.
     *
     * Generated from protobuf field <code>optional .google.cloud.compute.v1.CacheKeyPolicy cache_key_policy = 159263727;</code>
     * @return \Google\Cloud\Compute\V1\CacheKeyPolicy|null
     */
    public function getCacheKeyPolicy()
    {
        return $this->cache_key_policy;
    }

    public function hasCacheKeyPolicy()
    {
        return isset($this->cache_key_policy);
    }

    public function clearCacheKeyPolicy()
    {
        unset($this->cache_key_policy);
    }

    /**
     * The CacheKeyPolicy for this CdnPolicy.
     *
     * Generated from protobuf field <code>optional .google.cloud.compute.v1.CacheKeyPolicy cache_key_policy = 159263727;</code>
     * @param \Google\Cloud\Compute\V1\CacheKeyPolicy $var
     * @return $this
     */
    public function setCacheKeyPolicy($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Compute\V1\CacheKeyPolicy::class);
        $this->cache_key_policy = $var;

        return $this;
    }

    /**
     * Specifies the cache setting for all responses from this backend. The possible values are: USE_ORIGIN_HEADERS Requires the origin to set valid caching headers to cache content. Responses without these headers will not be cached at Google's edge, and will require a full trip to the origin on every request, potentially impacting performance and increasing load on the origin server. FORCE_CACHE_ALL Cache all content, ignoring any "private", "no-store" or "no-cache" directives in Cache-Control response headers. Warning: this may result in Cloud CDN caching private, per-user (user identifiable) content. CACHE_ALL_STATIC Automatically cache static content, including common image formats, media (video and audio), and web assets (JavaScript and CSS). Requests and responses that are marked as uncacheable, as well as dynamic content (including HTML), will not be cached. If no value is provided for cdnPolicy.cacheMode, it defaults to CACHE_ALL_STATIC.
     * Check the CacheMode enum for the list of possible values.
     *
     * Generated from protobuf field <code>optional string cache_mode = 28877888;</code>
     * @return string
     */
    public function getCacheMode()
    {
        return isset($this->cache_mode) ? $this->cache_mode : '';
    }

    public function hasCacheMode()
    {
        return isset($this->cache_mode);
    }

    public function clearCacheMode()
    {
        unset($this->cache_mode);
    }

    /**
     * Specifies the cache setting for all responses from this backend. The possible values are: USE_ORIGIN_HEADERS Requires the origin to set valid caching headers to cache content. Responses without these headers will not be cached at Google's edge, and will require a full trip to the origin on every request, potentially impacting performance and increasing load on the origin server. FORCE_CACHE_ALL Cache all content, ignoring any "private", "no-store" or "no-cache" directives in Cache-Control response headers. Warning: this may result in Cloud CDN caching private, per-user (user identifiable) content. CACHE_ALL_STATIC Automatically cache static content, including common image formats, media (video and audio), and web assets (JavaScript and CSS). Requests and responses that are marked as uncacheable, as well as dynamic content (including HTML), will not be cached. If no value is provided for cdnPolicy.cacheMode, it defaults to CACHE_ALL_STATIC.
     * Check the CacheMode enum for the list of possible values.
     *
     * Generated from protobuf field <code>optional string cache_mode = 28877888;</code>
     * @param string $var
     * @return $this
     */
    public function setCacheMode($var)
    {
        GPBUtil::checkString($var, True);
        $this->cache_mode = $var;

        return $this;
    }

    /**
     * Specifies a separate client (e.g. browser client) maximum TTL. This is used to clamp the max-age (or Expires) value sent to the client. With FORCE_CACHE_ALL, the lesser of client_ttl and default_ttl is used for the response max-age directive, along with a "public" directive. For cacheable content in CACHE_ALL_STATIC mode, client_ttl clamps the max-age from the origin (if specified), or else sets the response max-age directive to the lesser of the client_ttl and default_ttl, and also ensures a "public" cache-control directive is present. If a client TTL is not specified, a default value (1 hour) will be used. The maximum allowed value is 31,622,400s (1 year).
     *
     * Generated from protobuf field <code>optional int32 client_ttl = 29034360;</code>
     * @return int
     */
    public function getClientTtl()
    {
        return isset($this->client_ttl) ? $this->client_ttl : 0;
    }

    public function hasClientTtl()
    {
        return isset($this->client_ttl);
    }

    public function clearClientTtl()
    {
        unset($this->client_ttl);
    }

    /**
     * Specifies a separate client (e.g. browser client) maximum TTL. This is used to clamp the max-age (or Expires) value sent to the client. With FORCE_CACHE_ALL, the lesser of client_ttl and default_ttl is used for the response max-age directive, along with a "public" directive. For cacheable content in CACHE_ALL_STATIC mode, client_ttl clamps the max-age from the origin (if specified), or else sets the response max-age directive to the lesser of the client_ttl and default_ttl, and also ensures a "public" cache-control directive is present. If a client TTL is not specified, a default value (1 hour) will be used. The maximum allowed value is 31,622,400s (1 year).
     *
     * Generated from protobuf field <code>optional int32 client_ttl = 29034360;</code>
     * @param int $var
     * @return $this
     */
    public function setClientTtl($var)
    {
        GPBUtil::checkInt32($var);
        $this->client_ttl = $var;

        return $this;
    }

    /**
     * Specifies the default TTL for cached content served by this origin for responses that do not have an existing valid TTL (max-age or s-maxage). Setting a TTL of "0" means "always revalidate". The value of defaultTTL cannot be set to a value greater than that of maxTTL, but can be equal. When the cacheMode is set to FORCE_CACHE_ALL, the defaultTTL will overwrite the TTL set in all responses. The maximum allowed value is 31,622,400s (1 year), noting that infrequently accessed objects may be evicted from the cache before the defined TTL.
     *
     * Generated from protobuf field <code>optional int32 default_ttl = 100253422;</code>
     * @return int
     */
    public function getDefaultTtl()
    {
        return isset($this->default_ttl) ? $this->default_ttl : 0;
    }

    public function hasDefaultTtl()
    {
        return isset($this->default_ttl);
    }

    public function clearDefaultTtl()
    {
        unset($this->default_ttl);
    }

    /**
     * Specifies the default TTL for cached content served by this origin for responses that do not have an existing valid TTL (max-age or s-maxage). Setting a TTL of "0" means "always revalidate". The value of defaultTTL cannot be set to a value greater than that of maxTTL, but can be equal. When the cacheMode is set to FORCE_CACHE_ALL, the defaultTTL will overwrite the TTL set in all responses. The maximum allowed value is 31,622,400s (1 year), noting that infrequently accessed objects may be evicted from the cache before the defined TTL.
     *
     * Generated from protobuf field <code>optional int32 default_ttl = 100253422;</code>
     * @param int $var
     * @return $this
     */
    public function setDefaultTtl($var)
    {
        GPBUtil::checkInt32($var);
        $this->default_ttl = $var;

        return $this;
    }

    /**
     * Specifies the maximum allowed TTL for cached content served by this origin. Cache directives that attempt to set a max-age or s-maxage higher than this, or an Expires header more than maxTTL seconds in the future will be capped at the value of maxTTL, as if it were the value of an s-maxage Cache-Control directive. Headers sent to the client will not be modified. Setting a TTL of "0" means "always revalidate". The maximum allowed value is 31,622,400s (1 year), noting that infrequently accessed objects may be evicted from the cache before the defined TTL.
     *
     * Generated from protobuf field <code>optional int32 max_ttl = 307578001;</code>
     * @return int
     */
    public function getMaxTtl()
    {
        return isset($this->max_ttl) ? $this->max_ttl : 0;
    }

    public function hasMaxTtl()
    {
        return isset($this->max_ttl);
    }

    public function clearMaxTtl()
    {
        unset($this->max_ttl);
    }

    /**
     * Specifies the maximum allowed TTL for cached content served by this origin. Cache directives that attempt to set a max-age or s-maxage higher than this, or an Expires header more than maxTTL seconds in the future will be capped at the value of maxTTL, as if it were the value of an s-maxage Cache-Control directive. Headers sent to the client will not be modified. Setting a TTL of "0" means "always revalidate". The maximum allowed value is 31,622,400s (1 year), noting that infrequently accessed objects may be evicted from the cache before the defined TTL.
     *
     * Generated from protobuf field <code>optional int32 max_ttl = 307578001;</code>
     * @param int $var
     * @return $this
     */
    public function setMaxTtl($var)
    {
        GPBUtil::checkInt32($var);
        $this->max_ttl = $var;

        return $this;
    }

    /**
     * Negative caching allows per-status code TTLs to be set, in order to apply fine-grained caching for common errors or redirects. This can reduce the load on your origin and improve end-user experience by reducing response latency. When the cache mode is set to CACHE_ALL_STATIC or USE_ORIGIN_HEADERS, negative caching applies to responses with the specified response code that lack any Cache-Control, Expires, or Pragma: no-cache directives. When the cache mode is set to FORCE_CACHE_ALL, negative caching applies to all responses with the specified response code, and override any caching headers. By default, Cloud CDN will apply the following default TTLs to these status codes: HTTP 300 (Multiple Choice), 301, 308 (Permanent Redirects): 10m HTTP 404 (Not Found), 410 (Gone), 451 (Unavailable For Legal Reasons): 120s HTTP 405 (Method Not Found), 421 (Misdirected Request), 501 (Not Implemented): 60s. These defaults can be overridden in negative_caching_policy.
     *
     * Generated from protobuf field <code>optional bool negative_caching = 336110005;</code>
     * @return bool
     */
    public function getNegativeCaching()
    {
        return isset($this->negative_caching) ? $this->negative_caching : false;
    }

    public function hasNegativeCaching()
    {
        return isset($this->negative_caching);
    }

    public function clearNegativeCaching()
    {
        unset($this->negative_caching);
    }

    /**
     * Negative caching allows per-status code TTLs to be set, in order to apply fine-grained caching for common errors or redirects. This can reduce the load on your origin and improve end-user experience by reducing response latency. When the cache mode is set to CACHE_ALL_STATIC or USE_ORIGIN_HEADERS, negative caching applies to responses with the specified response code that lack any Cache-Control, Expires, or Pragma: no-cache directives. When the cache mode is set to FORCE_CACHE_ALL, negative caching applies to all responses with the specified response code, and override any caching headers. By default, Cloud CDN will apply the following default TTLs to these status codes: HTTP 300 (Multiple Choice), 301, 308 (Permanent Redirects): 10m HTTP 404 (Not Found), 410 (Gone), 451 (Unavailable For Legal Reasons): 120s HTTP 405 (Method Not Found), 421 (Misdirected Request), 501 (Not Implemented): 60s. These defaults can be overridden in negative_caching_policy.
     *
     * Generated from protobuf field <code>optional bool negative_caching = 336110005;</code>
     * @param bool $var
     * @return $this
     */
    public function setNegativeCaching($var)
    {
        GPBUtil::checkBool($var);
        $this->negative_caching = $var;

        return $this;
    }

    /**
     * Sets a cache TTL for the specified HTTP status code. negative_caching must be enabled to configure negative_caching_policy. Omitting the policy and leaving negative_caching enabled will use Cloud CDN's default cache TTLs. Note that when specifying an explicit negative_caching_policy, you should take care to specify a cache TTL for all response codes that you wish to cache. Cloud CDN will not apply any default negative caching when a policy exists.
     *
     * Generated from protobuf field <code>repeated .google.cloud.compute.v1.BackendServiceCdnPolicyNegativeCachingPolicy negative_caching_policy = 155359996;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getNegativeCachingPolicy()
    {
        return $this->negative_caching_policy;
    }

    /**
     * Sets a cache TTL for the specified HTTP status code. negative_caching must be enabled to configure negative_caching_policy. Omitting the policy and leaving negative_caching enabled will use Cloud CDN's default cache TTLs. Note that when specifying an explicit negative_caching_policy, you should take care to specify a cache TTL for all response codes that you wish to cache. Cloud CDN will not apply any default negative caching when a policy exists.
     *
     * Generated from protobuf field <code>repeated .google.cloud.compute.v1.BackendServiceCdnPolicyNegativeCachingPolicy negative_caching_policy = 155359996;</code>
     * @param array<\Google\Cloud\Compute\V1\BackendServiceCdnPolicyNegativeCachingPolicy>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setNegativeCachingPolicy($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Compute\V1\BackendServiceCdnPolicyNegativeCachingPolicy::class);
        $this->negative_caching_policy = $arr;

        return $this;
    }

    /**
     * If true then Cloud CDN will combine multiple concurrent cache fill requests into a small number of requests to the origin.
     *
     * Generated from protobuf field <code>optional bool request_coalescing = 532808276;</code>
     * @return bool
     */
    public function getRequestCoalescing()
    {
        return isset($this->request_coalescing) ? $this->request_coalescing : false;
    }

    public function hasRequestCoalescing()
    {
        return isset($this->request_coalescing);
    }

    public function clearRequestCoalescing()
    {
        unset($this->request_coalescing);
    }

    /**
     * If true then Cloud CDN will combine multiple concurrent cache fill requests into a small number of requests to the origin.
     *
     * Generated from protobuf field <code>optional bool request_coalescing = 532808276;</code>
     * @param bool $var
     * @return $this
     */
    public function setRequestCoalescing($var)
    {
        GPBUtil::checkBool($var);
        $this->request_coalescing = $var;

        return $this;
    }

    /**
     * Serve existing content from the cache (if available) when revalidating content with the origin, or when an error is encountered when refreshing the cache. This setting defines the default "max-stale" duration for any cached responses that do not specify a max-stale directive. Stale responses that exceed the TTL configured here will not be served. The default limit (max-stale) is 86400s (1 day), which will allow stale content to be served up to this limit beyond the max-age (or s-maxage) of a cached response. The maximum allowed value is 604800 (1 week). Set this to zero (0) to disable serve-while-stale.
     *
     * Generated from protobuf field <code>optional int32 serve_while_stale = 236682203;</code>
     * @return int
     */
    public function getServeWhileStale()
    {
        return isset($this->serve_while_stale) ? $this->serve_while_stale : 0;
    }

    public function hasServeWhileStale()
    {
        return isset($this->serve_while_stale);
    }

    public function clearServeWhileStale()
    {
        unset($this->serve_while_stale);
    }

    /**
     * Serve existing content from the cache (if available) when revalidating content with the origin, or when an error is encountered when refreshing the cache. This setting defines the default "max-stale" duration for any cached responses that do not specify a max-stale directive. Stale responses that exceed the TTL configured here will not be served. The default limit (max-stale) is 86400s (1 day), which will allow stale content to be served up to this limit beyond the max-age (or s-maxage) of a cached response. The maximum allowed value is 604800 (1 week). Set this to zero (0) to disable serve-while-stale.
     *
     * Generated from protobuf field <code>optional int32 serve_while_stale = 236682203;</code>
     * @param int $var
     * @return $this
     */
    public function setServeWhileStale($var)
    {
        GPBUtil::checkInt32($var);
        $this->serve_while_stale = $var;

        return $this;
    }

    /**
     * Maximum number of seconds the response to a signed URL request will be considered fresh. After this time period, the response will be revalidated before being served. Defaults to 1hr (3600s). When serving responses to signed URL requests, Cloud CDN will internally behave as though all responses from this backend had a "Cache-Control: public, max-age=[TTL]" header, regardless of any existing Cache-Control header. The actual headers served in responses will not be altered.
     *
     * Generated from protobuf field <code>optional int64 signed_url_cache_max_age_sec = 269374534;</code>
     * @return int|string
     */
    public function getSignedUrlCacheMaxAgeSec()
    {
        return isset($this->signed_url_cache_max_age_sec) ? $this->signed_url_cache_max_age_sec : 0;
    }

    public function hasSignedUrlCacheMaxAgeSec()
    {
        return isset($this->signed_url_cache_max_age_sec);
    }

    public function clearSignedUrlCacheMaxAgeSec()
    {
        unset($this->signed_url_cache_max_age_sec);
    }

    /**
     * Maximum number of seconds the response to a signed URL request will be considered fresh. After this time period, the response will be revalidated before being served. Defaults to 1hr (3600s). When serving responses to signed URL requests, Cloud CDN will internally behave as though all responses from this backend had a "Cache-Control: public, max-age=[TTL]" header, regardless of any existing Cache-Control header. The actual headers served in responses will not be altered.
     *
     * Generated from protobuf field <code>optional int64 signed_url_cache_max_age_sec = 269374534;</code>
     * @param int|string $var
     * @return $this
     */
    public function setSignedUrlCacheMaxAgeSec($var)
    {
        GPBUtil::checkInt64($var);
        $this->signed_url_cache_max_age_sec = $var;

        return $this;
    }

    /**
     * [Output Only] Names of the keys for signing request URLs.
     *
     * Generated from protobuf field <code>repeated string signed_url_key_names = 371848885;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getSignedUrlKeyNames()
    {
        return $this->signed_url_key_names;
    }

    /**
     * [Output Only] Names of the keys for signing request URLs.
     *
     * Generated from protobuf field <code>repeated string signed_url_key_names = 371848885;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setSignedUrlKeyNames($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->signed_url_key_names = $arr;

        return $this;
    }

}

