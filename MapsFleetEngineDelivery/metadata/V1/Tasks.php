<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/maps/fleetengine/delivery/v1/tasks.proto

namespace GPBMetadata\Google\Maps\Fleetengine\Delivery\V1;

class Tasks
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Maps\Fleetengine\Delivery\V1\Common::initOnce();
        \GPBMetadata\Google\Maps\Fleetengine\Delivery\V1\DeliveryVehicles::initOnce();
        \GPBMetadata\Google\Protobuf\Duration::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
/google/maps/fleetengine/delivery/v1/tasks.protomaps.fleetengine.delivery.v1google/api/resource.proto0google/maps/fleetengine/delivery/v1/common.proto;google/maps/fleetengine/delivery/v1/delivery_vehicles.protogoogle/protobuf/duration.protogoogle/protobuf/timestamp.proto"�
Task
name (	=
type (2\'.maps.fleetengine.delivery.v1.Task.TypeB�A�A<
state (2(.maps.fleetengine.delivery.v1.Task.StateB�AD
task_outcome	 (2..maps.fleetengine.delivery.v1.Task.TaskOutcome5
task_outcome_time
 (2.google.protobuf.TimestampI
task_outcome_location (2*.maps.fleetengine.delivery.v1.LocationInfob
task_outcome_location_source (2<.maps.fleetengine.delivery.v1.Task.TaskOutcomeLocationSource
tracking_id (	B�A 
delivery_vehicle_id (	B�AI
planned_location (2*.maps.fleetengine.delivery.v1.LocationInfoB�A8
task_duration (2.google.protobuf.DurationB�A�AD
target_time_window (2(.maps.fleetengine.delivery.v1.TimeWindowX
journey_sharing_info (25.maps.fleetengine.delivery.v1.Task.JourneySharingInfoB�AW
task_tracking_view_config (24.maps.fleetengine.delivery.v1.TaskTrackingViewConfig?

attributes (2+.maps.fleetengine.delivery.v1.TaskAttribute�
JourneySharingInfo_
"remaining_vehicle_journey_segments (23.maps.fleetengine.delivery.v1.VehicleJourneySegmentL
last_location (25.maps.fleetengine.delivery.v1.DeliveryVehicleLocation
last_location_snappable ("[
Type
TYPE_UNSPECIFIED 

PICKUP
DELIVERY
SCHEDULED_STOP
UNAVAILABLE"4
State
STATE_UNSPECIFIED 
OPEN

CLOSED"F
TaskOutcome
TASK_OUTCOME_UNSPECIFIED 
	SUCCEEDED

FAILED"r
TaskOutcomeLocationSource,
(TASK_OUTCOME_LOCATION_SOURCE_UNSPECIFIED 
PROVIDER
LAST_VEHICLE_LOCATION:G�AD
fleetengine.googleapis.com/Task!providers/{provider}/tasks/{task}"�
TaskTrackingViewConfigo
 route_polyline_points_visibility (2E.maps.fleetengine.delivery.v1.TaskTrackingViewConfig.VisibilityOptionp
!estimated_arrival_time_visibility (2E.maps.fleetengine.delivery.v1.TaskTrackingViewConfig.VisibilityOptionx
)estimated_task_completion_time_visibility (2E.maps.fleetengine.delivery.v1.TaskTrackingViewConfig.VisibilityOptiont
%remaining_driving_distance_visibility (2E.maps.fleetengine.delivery.v1.TaskTrackingViewConfig.VisibilityOptionn
remaining_stop_count_visibility (2E.maps.fleetengine.delivery.v1.TaskTrackingViewConfig.VisibilityOptionj
vehicle_location_visibility (2E.maps.fleetengine.delivery.v1.TaskTrackingViewConfig.VisibilityOption�
VisibilityOption(
remaining_stop_count_threshold (H T
/duration_until_estimated_arrival_time_threshold (2.google.protobuf.DurationH 5
+remaining_driving_distance_meters_threshold (H 
always (H 
never (H B
visibility_optionB�
\'com.google.maps.fleetengine.delivery.v1BTasksPZIcloud.google.com/go/maps/fleetengine/delivery/apiv1/deliverypb;deliverypb�CFED�#Google.Maps.FleetEngine.Delivery.V1�#Google\\Maps\\FleetEngine\\Delivery\\V1�\'Google::Maps::FleetEngine::Delivery::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

