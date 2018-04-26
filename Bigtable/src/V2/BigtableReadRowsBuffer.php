<?php

namespace Google\Cloud\Bigtable\V2;

use Google\Cloud\Bigtable\V2\Exception\InvalidChunkException;
use Google\ApiCore\ServerStream;

class BigtableReadRowsBuffer
{
    /**
     * @var BigtableRowBuffer
     */
    private $rowBuffer;

    /**
     * @var BigtableCellBuffer
     */
    private $cellBuffer;

    public function __construct()
    {
        $this->reset();
    }

    private function reset()
    {
        $this->rowBuffer = new BigtableRowBuffer();
        $this->cellBuffer = new BigtableCellBuffer();
    }

    /**
     * Ensure that the chunk is a valid reset row chunk.
     *
     * @param ReadRowsResponse_CellChunk $chunk
     *
     * @throws InvalidChunkException if the chunk is invalid
     */
    private function validateResetRowChunk($chunk)
    {
        InvalidChunkException::assert($chunk->getRowKey() === '');
        InvalidChunkException::assert(is_null($chunk->getFamilyName()));
        InvalidChunkException::assert(is_null($chunk->getQualifier()));
        InvalidChunkException::assert($chunk->getLabels()->count() === 0);
        InvalidChunkException::assert($chunk->getValueSize() === 0);
        InvalidChunkException::assert($chunk->getValue() === '');
    }

    /**
     * Read the cell chunks, yielding rows as they complete.
     *
     * @param ReadRowsResponse_CellChunk[] $chunks
     *
     * @return \Generator of BigtableRowBuffer
     *
     * @throws InvalidChunkException if the stream reaches an inconsistent state
     */
    public function consumeCellChunks($chunks)
    {
        foreach ($chunks as $chunk) {
            if ($chunk->getResetRow()) {
                $this->validateResetRowChunk($chunk);
                $this->reset();
                continue;
            };

            $this->cellBuffer->merge($chunk);

            if ($this->cellBuffer->getState() === BigtableCellBuffer::COMPLETE) {
                $this->rowBuffer->merge($this->cellBuffer);
            }

            if ($this->rowBuffer->getState() === BigtableRowBuffer::COMPLETE) {
                yield $this->rowBuffer;
                $this->reset();
            }
        };
    }

    /**
     * @param ServerStream $stream stream of ReadRowsResponse to consume
     *
     * @return \Generator of BigtableRowBuffer
     *
     * @throws InvalidChunkException if the stream reaches an inconsistent state
     */
    public function consumeStream(ServerStream $stream)
    {
        foreach ($stream->readAll() as $response) {
            $this->consumeCellChunks($response->getChunks());
        }
    }
}
