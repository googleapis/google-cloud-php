<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/bigtable/v2/bigtable.proto

namespace Google\Cloud\Bigtable\V2\ReadChangeStreamResponse;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A message indicating that the client should stop reading from the stream.
 * If status is OK and `continuation_tokens` & `new_partitions` are empty, the
 * stream has finished (for example if there was an `end_time` specified).
 * If `continuation_tokens` & `new_partitions` are present, then a change in
 * partitioning requires the client to open a new stream for each token to
 * resume reading. Example:
 *                                      [B,      D) ends
 *                                           |
 *                                           v
 *                   new_partitions:  [A,  C) [C,  E)
 *     continuation_tokens.partitions:  [B,C) [C,D)
 *                                      ^---^ ^---^
 *                                      ^     ^
 *                                      |     |
 *                                      |     StreamContinuationToken 2
 *                                      |
 *                                      StreamContinuationToken 1
 * To read the new partition [A,C), supply the continuation tokens whose
 * ranges cover the new partition, for example ContinuationToken[A,B) &
 * ContinuationToken[B,C).
 *
 * Generated from protobuf message <code>google.bigtable.v2.ReadChangeStreamResponse.CloseStream</code>
 */
class CloseStream extends \Google\Protobuf\Internal\Message
{
    /**
     * The status of the stream.
     *
     * Generated from protobuf field <code>.google.rpc.Status status = 1;</code>
     */
    protected $status = null;
    /**
     * If non-empty, contains the information needed to resume reading their
     * associated partitions.
     *
     * Generated from protobuf field <code>repeated .google.bigtable.v2.StreamContinuationToken continuation_tokens = 2;</code>
     */
    private $continuation_tokens;
    /**
     * If non-empty, contains the new partitions to start reading from, which
     * are related to but not necessarily identical to the partitions for the
     * above `continuation_tokens`.
     *
     * Generated from protobuf field <code>repeated .google.bigtable.v2.StreamPartition new_partitions = 3;</code>
     */
    private $new_partitions;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Rpc\Status $status
     *           The status of the stream.
     *     @type array<\Google\Cloud\Bigtable\V2\StreamContinuationToken>|\Google\Protobuf\Internal\RepeatedField $continuation_tokens
     *           If non-empty, contains the information needed to resume reading their
     *           associated partitions.
     *     @type array<\Google\Cloud\Bigtable\V2\StreamPartition>|\Google\Protobuf\Internal\RepeatedField $new_partitions
     *           If non-empty, contains the new partitions to start reading from, which
     *           are related to but not necessarily identical to the partitions for the
     *           above `continuation_tokens`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Bigtable\V2\Bigtable::initOnce();
        parent::__construct($data);
    }

    /**
     * The status of the stream.
     *
     * Generated from protobuf field <code>.google.rpc.Status status = 1;</code>
     * @return \Google\Rpc\Status|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function hasStatus()
    {
        return isset($this->status);
    }

    public function clearStatus()
    {
        unset($this->status);
    }

    /**
     * The status of the stream.
     *
     * Generated from protobuf field <code>.google.rpc.Status status = 1;</code>
     * @param \Google\Rpc\Status $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkMessage($var, \Google\Rpc\Status::class);
        $this->status = $var;

        return $this;
    }

    /**
     * If non-empty, contains the information needed to resume reading their
     * associated partitions.
     *
     * Generated from protobuf field <code>repeated .google.bigtable.v2.StreamContinuationToken continuation_tokens = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getContinuationTokens()
    {
        return $this->continuation_tokens;
    }

    /**
     * If non-empty, contains the information needed to resume reading their
     * associated partitions.
     *
     * Generated from protobuf field <code>repeated .google.bigtable.v2.StreamContinuationToken continuation_tokens = 2;</code>
     * @param array<\Google\Cloud\Bigtable\V2\StreamContinuationToken>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setContinuationTokens($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Bigtable\V2\StreamContinuationToken::class);
        $this->continuation_tokens = $arr;

        return $this;
    }

    /**
     * If non-empty, contains the new partitions to start reading from, which
     * are related to but not necessarily identical to the partitions for the
     * above `continuation_tokens`.
     *
     * Generated from protobuf field <code>repeated .google.bigtable.v2.StreamPartition new_partitions = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getNewPartitions()
    {
        return $this->new_partitions;
    }

    /**
     * If non-empty, contains the new partitions to start reading from, which
     * are related to but not necessarily identical to the partitions for the
     * above `continuation_tokens`.
     *
     * Generated from protobuf field <code>repeated .google.bigtable.v2.StreamPartition new_partitions = 3;</code>
     * @param array<\Google\Cloud\Bigtable\V2\StreamPartition>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setNewPartitions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Bigtable\V2\StreamPartition::class);
        $this->new_partitions = $arr;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(CloseStream::class, \Google\Cloud\Bigtable\V2\ReadChangeStreamResponse_CloseStream::class);

