<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\BigQuery\Reservation\V1;

/**
 * This API allows users to manage their flat-rate BigQuery reservations.
 *
 * A reservation provides computational resource guarantees, in the form of
 * [slots](https://cloud.google.com/bigquery/docs/slots), to users. A slot is a
 * unit of computational power in BigQuery, and serves as the basic unit of
 * parallelism. In a scan of a multi-partitioned table, a single slot operates
 * on a single partition of the table. A reservation resource exists as a child
 * resource of the admin project and location, e.g.:
 *   `projects/myproject/locations/US/reservations/reservationName`.
 *
 * A capacity commitment is a way to purchase compute capacity for BigQuery jobs
 * (in the form of slots) with some committed period of usage. A capacity
 * commitment resource exists as a child resource of the admin project and
 * location, e.g.:
 *   `projects/myproject/locations/US/capacityCommitments/id`.
 */
class ReservationServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new reservation resource.
     * @param \Google\Cloud\BigQuery\Reservation\V1\CreateReservationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateReservation(\Google\Cloud\BigQuery\Reservation\V1\CreateReservationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/CreateReservation',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\Reservation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all the reservations for the project in the specified location.
     * @param \Google\Cloud\BigQuery\Reservation\V1\ListReservationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListReservations(\Google\Cloud\BigQuery\Reservation\V1\ListReservationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/ListReservations',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\ListReservationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns information about the reservation.
     * @param \Google\Cloud\BigQuery\Reservation\V1\GetReservationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetReservation(\Google\Cloud\BigQuery\Reservation\V1\GetReservationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/GetReservation',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\Reservation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a reservation.
     * Returns `google.rpc.Code.FAILED_PRECONDITION` when reservation has
     * assignments.
     * @param \Google\Cloud\BigQuery\Reservation\V1\DeleteReservationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteReservation(\Google\Cloud\BigQuery\Reservation\V1\DeleteReservationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/DeleteReservation',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing reservation resource.
     * @param \Google\Cloud\BigQuery\Reservation\V1\UpdateReservationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateReservation(\Google\Cloud\BigQuery\Reservation\V1\UpdateReservationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/UpdateReservation',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\Reservation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new capacity commitment resource.
     * @param \Google\Cloud\BigQuery\Reservation\V1\CreateCapacityCommitmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCapacityCommitment(\Google\Cloud\BigQuery\Reservation\V1\CreateCapacityCommitmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/CreateCapacityCommitment',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\CapacityCommitment', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all the capacity commitments for the admin project.
     * @param \Google\Cloud\BigQuery\Reservation\V1\ListCapacityCommitmentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCapacityCommitments(\Google\Cloud\BigQuery\Reservation\V1\ListCapacityCommitmentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/ListCapacityCommitments',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\ListCapacityCommitmentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns information about the capacity commitment.
     * @param \Google\Cloud\BigQuery\Reservation\V1\GetCapacityCommitmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCapacityCommitment(\Google\Cloud\BigQuery\Reservation\V1\GetCapacityCommitmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/GetCapacityCommitment',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\CapacityCommitment', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a capacity commitment. Attempting to delete capacity commitment
     * before its commitment_end_time will fail with the error code
     * `google.rpc.Code.FAILED_PRECONDITION`.
     * @param \Google\Cloud\BigQuery\Reservation\V1\DeleteCapacityCommitmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCapacityCommitment(\Google\Cloud\BigQuery\Reservation\V1\DeleteCapacityCommitmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/DeleteCapacityCommitment',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing capacity commitment.
     *
     * Only `plan` and `renewal_plan` fields can be updated.
     *
     * Plan can only be changed to a plan of a longer commitment period.
     * Attempting to change to a plan with shorter commitment period will fail
     * with the error code `google.rpc.Code.FAILED_PRECONDITION`.
     * @param \Google\Cloud\BigQuery\Reservation\V1\UpdateCapacityCommitmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCapacityCommitment(\Google\Cloud\BigQuery\Reservation\V1\UpdateCapacityCommitmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/UpdateCapacityCommitment',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\CapacityCommitment', 'decode'],
        $metadata, $options);
    }

    /**
     * Splits capacity commitment to two commitments of the same plan and
     * `commitment_end_time`.
     *
     * A common use case is to enable downgrading commitments.
     *
     * For example, in order to downgrade from 10000 slots to 8000, you might
     * split a 10000 capacity commitment into commitments of 2000 and 8000. Then,
     * you delete the first one after the commitment end time passes.
     * @param \Google\Cloud\BigQuery\Reservation\V1\SplitCapacityCommitmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SplitCapacityCommitment(\Google\Cloud\BigQuery\Reservation\V1\SplitCapacityCommitmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/SplitCapacityCommitment',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\SplitCapacityCommitmentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Merges capacity commitments of the same plan into a single commitment.
     *
     * The resulting capacity commitment has the greater commitment_end_time
     * out of the to-be-merged capacity commitments.
     *
     * Attempting to merge capacity commitments of different plan will fail
     * with the error code `google.rpc.Code.FAILED_PRECONDITION`.
     * @param \Google\Cloud\BigQuery\Reservation\V1\MergeCapacityCommitmentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MergeCapacityCommitments(\Google\Cloud\BigQuery\Reservation\V1\MergeCapacityCommitmentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/MergeCapacityCommitments',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\CapacityCommitment', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an assignment object which allows the given project to submit jobs
     * of a certain type using slots from the specified reservation.
     *
     * Currently a
     * resource (project, folder, organization) can only have one assignment per
     * each (job_type, location) combination, and that reservation will be used
     * for all jobs of the matching type.
     *
     * Different assignments can be created on different levels of the
     * projects, folders or organization hierarchy.  During query execution,
     * the assignment is looked up at the project, folder and organization levels
     * in that order. The first assignment found is applied to the query.
     *
     * When creating assignments, it does not matter if other assignments exist at
     * higher levels.
     *
     * Example:
     *
     * * The organization `organizationA` contains two projects, `project1`
     *   and `project2`.
     * * Assignments for all three entities (`organizationA`, `project1`, and
     *   `project2`) could all be created and mapped to the same or different
     *   reservations.
     *
     * "None" assignments represent an absence of the assignment. Projects
     * assigned to None use on-demand pricing. To create a "None" assignment, use
     * "none" as a reservation_id in the parent. Example parent:
     * `projects/myproject/locations/US/reservations/none`.
     *
     * Returns `google.rpc.Code.PERMISSION_DENIED` if user does not have
     * 'bigquery.admin' permissions on the project using the reservation
     * and the project that owns this reservation.
     *
     * Returns `google.rpc.Code.INVALID_ARGUMENT` when location of the assignment
     * does not match location of the reservation.
     * @param \Google\Cloud\BigQuery\Reservation\V1\CreateAssignmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAssignment(\Google\Cloud\BigQuery\Reservation\V1\CreateAssignmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/CreateAssignment',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\Assignment', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists assignments.
     *
     * Only explicitly created assignments will be returned.
     *
     * Example:
     *
     * * Organization `organizationA` contains two projects, `project1` and
     *   `project2`.
     * * Reservation `res1` exists and was created previously.
     * * CreateAssignment was used previously to define the following
     *   associations between entities and reservations: `<organizationA, res1>`
     *   and `<project1, res1>`
     *
     * In this example, ListAssignments will just return the above two assignments
     * for reservation `res1`, and no expansion/merge will happen.
     *
     * The wildcard "-" can be used for
     * reservations in the request. In that case all assignments belongs to the
     * specified project and location will be listed.
     *
     * **Note** "-" cannot be used for projects nor locations.
     * @param \Google\Cloud\BigQuery\Reservation\V1\ListAssignmentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAssignments(\Google\Cloud\BigQuery\Reservation\V1\ListAssignmentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/ListAssignments',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\ListAssignmentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a assignment. No expansion will happen.
     *
     * Example:
     *
     * * Organization `organizationA` contains two projects, `project1` and
     *   `project2`.
     * * Reservation `res1` exists and was created previously.
     * * CreateAssignment was used previously to define the following
     *   associations between entities and reservations: `<organizationA, res1>`
     *   and `<project1, res1>`
     *
     * In this example, deletion of the `<organizationA, res1>` assignment won't
     * affect the other assignment `<project1, res1>`. After said deletion,
     * queries from `project1` will still use `res1` while queries from
     * `project2` will switch to use on-demand mode.
     * @param \Google\Cloud\BigQuery\Reservation\V1\DeleteAssignmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAssignment(\Google\Cloud\BigQuery\Reservation\V1\DeleteAssignmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/DeleteAssignment',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Deprecated: Looks up assignments for a specified resource for a particular
     * region. If the request is about a project:
     *
     * 1. Assignments created on the project will be returned if they exist.
     * 2. Otherwise assignments created on the closest ancestor will be
     *    returned.
     * 3. Assignments for different JobTypes will all be returned.
     *
     * The same logic applies if the request is about a folder.
     *
     * If the request is about an organization, then assignments created on the
     * organization will be returned (organization doesn't have ancestors).
     *
     * Comparing to ListAssignments, there are some behavior
     * differences:
     *
     * 1. permission on the assignee will be verified in this API.
     * 2. Hierarchy lookup (project->folder->organization) happens in this API.
     * 3. Parent here is `projects/&#42;/locations/*`, instead of
     *    `projects/&#42;/locations/*reservations/*`.
     *
     * **Note** "-" cannot be used for projects
     * nor locations.
     * @param \Google\Cloud\BigQuery\Reservation\V1\SearchAssignmentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchAssignments(\Google\Cloud\BigQuery\Reservation\V1\SearchAssignmentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/SearchAssignments',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\SearchAssignmentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Looks up assignments for a specified resource for a particular region.
     * If the request is about a project:
     *
     * 1. Assignments created on the project will be returned if they exist.
     * 2. Otherwise assignments created on the closest ancestor will be
     *    returned.
     * 3. Assignments for different JobTypes will all be returned.
     *
     * The same logic applies if the request is about a folder.
     *
     * If the request is about an organization, then assignments created on the
     * organization will be returned (organization doesn't have ancestors).
     *
     * Comparing to ListAssignments, there are some behavior
     * differences:
     *
     * 1. permission on the assignee will be verified in this API.
     * 2. Hierarchy lookup (project->folder->organization) happens in this API.
     * 3. Parent here is `projects/&#42;/locations/*`, instead of
     *    `projects/&#42;/locations/*reservations/*`.
     * @param \Google\Cloud\BigQuery\Reservation\V1\SearchAllAssignmentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchAllAssignments(\Google\Cloud\BigQuery\Reservation\V1\SearchAllAssignmentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/SearchAllAssignments',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\SearchAllAssignmentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Moves an assignment under a new reservation.
     *
     * This differs from removing an existing assignment and recreating a new one
     * by providing a transactional change that ensures an assignee always has an
     * associated reservation.
     * @param \Google\Cloud\BigQuery\Reservation\V1\MoveAssignmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MoveAssignment(\Google\Cloud\BigQuery\Reservation\V1\MoveAssignmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/MoveAssignment',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\Assignment', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing assignment.
     *
     * Only the `priority` field can be updated.
     * @param \Google\Cloud\BigQuery\Reservation\V1\UpdateAssignmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAssignment(\Google\Cloud\BigQuery\Reservation\V1\UpdateAssignmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/UpdateAssignment',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\Assignment', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a BI reservation.
     * @param \Google\Cloud\BigQuery\Reservation\V1\GetBiReservationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBiReservation(\Google\Cloud\BigQuery\Reservation\V1\GetBiReservationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/GetBiReservation',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\BiReservation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a BI reservation.
     *
     * Only fields specified in the `field_mask` are updated.
     *
     * A singleton BI reservation always exists with default size 0.
     * In order to reserve BI capacity it needs to be updated to an amount
     * greater than 0. In order to release BI capacity reservation size
     * must be set to 0.
     * @param \Google\Cloud\BigQuery\Reservation\V1\UpdateBiReservationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateBiReservation(\Google\Cloud\BigQuery\Reservation\V1\UpdateBiReservationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.reservation.v1.ReservationService/UpdateBiReservation',
        $argument,
        ['\Google\Cloud\BigQuery\Reservation\V1\BiReservation', 'decode'],
        $metadata, $options);
    }

}
