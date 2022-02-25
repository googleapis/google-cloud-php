<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 The Grafeas Authors. All rights reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//    http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Grafeas\V1;

/**
 * [Grafeas](https://grafeas.io) API.
 *
 * Retrieves analysis results of Cloud components such as Docker container
 * images.
 *
 * Analysis results are stored as a series of occurrences. An `Occurrence`
 * contains information about a specific analysis instance on a resource. An
 * occurrence refers to a `Note`. A note contains details describing the
 * analysis and is generally stored in a separate project, called a `Provider`.
 * Multiple occurrences can refer to the same note.
 *
 * For example, an SSL vulnerability could affect multiple images. In this case,
 * there would be one note for the vulnerability and an occurrence for each
 * image with the vulnerability referring to that note.
 */
class GrafeasGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Gets the specified occurrence.
     * @param \Grafeas\V1\GetOccurrenceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetOccurrence(\Grafeas\V1\GetOccurrenceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/GetOccurrence',
        $argument,
        ['\Grafeas\V1\Occurrence', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists occurrences for the specified project.
     * @param \Grafeas\V1\ListOccurrencesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListOccurrences(\Grafeas\V1\ListOccurrencesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/ListOccurrences',
        $argument,
        ['\Grafeas\V1\ListOccurrencesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified occurrence. For example, use this method to delete an
     * occurrence when the occurrence is no longer applicable for the given
     * resource.
     * @param \Grafeas\V1\DeleteOccurrenceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteOccurrence(\Grafeas\V1\DeleteOccurrenceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/DeleteOccurrence',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new occurrence.
     * @param \Grafeas\V1\CreateOccurrenceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateOccurrence(\Grafeas\V1\CreateOccurrenceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/CreateOccurrence',
        $argument,
        ['\Grafeas\V1\Occurrence', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates new occurrences in batch.
     * @param \Grafeas\V1\BatchCreateOccurrencesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchCreateOccurrences(\Grafeas\V1\BatchCreateOccurrencesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/BatchCreateOccurrences',
        $argument,
        ['\Grafeas\V1\BatchCreateOccurrencesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified occurrence.
     * @param \Grafeas\V1\UpdateOccurrenceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateOccurrence(\Grafeas\V1\UpdateOccurrenceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/UpdateOccurrence',
        $argument,
        ['\Grafeas\V1\Occurrence', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the note attached to the specified occurrence. Consumer projects can
     * use this method to get a note that belongs to a provider project.
     * @param \Grafeas\V1\GetOccurrenceNoteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetOccurrenceNote(\Grafeas\V1\GetOccurrenceNoteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/GetOccurrenceNote',
        $argument,
        ['\Grafeas\V1\Note', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the specified note.
     * @param \Grafeas\V1\GetNoteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNote(\Grafeas\V1\GetNoteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/GetNote',
        $argument,
        ['\Grafeas\V1\Note', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists notes for the specified project.
     * @param \Grafeas\V1\ListNotesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNotes(\Grafeas\V1\ListNotesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/ListNotes',
        $argument,
        ['\Grafeas\V1\ListNotesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified note.
     * @param \Grafeas\V1\DeleteNoteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteNote(\Grafeas\V1\DeleteNoteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/DeleteNote',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new note.
     * @param \Grafeas\V1\CreateNoteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateNote(\Grafeas\V1\CreateNoteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/CreateNote',
        $argument,
        ['\Grafeas\V1\Note', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates new notes in batch.
     * @param \Grafeas\V1\BatchCreateNotesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchCreateNotes(\Grafeas\V1\BatchCreateNotesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/BatchCreateNotes',
        $argument,
        ['\Grafeas\V1\BatchCreateNotesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified note.
     * @param \Grafeas\V1\UpdateNoteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateNote(\Grafeas\V1\UpdateNoteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/UpdateNote',
        $argument,
        ['\Grafeas\V1\Note', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists occurrences referencing the specified note. Provider projects can use
     * this method to get all occurrences across consumer projects referencing the
     * specified note.
     * @param \Grafeas\V1\ListNoteOccurrencesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNoteOccurrences(\Grafeas\V1\ListNoteOccurrencesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grafeas.v1.Grafeas/ListNoteOccurrences',
        $argument,
        ['\Grafeas\V1\ListNoteOccurrencesResponse', 'decode'],
        $metadata, $options);
    }

}
