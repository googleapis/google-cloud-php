<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/video/livestream/v1/resources.proto

namespace GPBMetadata\Google\Cloud\Video\Livestream\V1;

class Resources
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Cloud\Video\Livestream\V1\Outputs::initOnce();
        \GPBMetadata\Google\Protobuf\Duration::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        \GPBMetadata\Google\Rpc\Status::initOnce();
        $pool->internalAddGeneratedFile(
            '
�S
0google/cloud/video/livestream/v1/resources.proto google.cloud.video.livestream.v1google/api/resource.proto.google/cloud/video/livestream/v1/outputs.protogoogle/protobuf/duration.protogoogle/protobuf/timestamp.protogoogle/rpc/status.proto"�
Input
name (	4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AC
labels (23.google.cloud.video.livestream.v1.Input.LabelsEntry:
type (2,.google.cloud.video.livestream.v1.Input.Type:
tier (2,.google.cloud.video.livestream.v1.Input.Tier
uri (	B�AS
preprocessing_config	 (25.google.cloud.video.livestream.v1.PreprocessingConfigL
security_rules (24.google.cloud.video.livestream.v1.Input.SecurityRuleY
input_stream_property (25.google.cloud.video.livestream.v1.InputStreamPropertyB�A!
SecurityRule
	ip_ranges (	-
LabelsEntry
key (	
value (	:8"9
Type
TYPE_UNSPECIFIED 
	RTMP_PUSH
SRT_PUSH"5
Tier
TIER_UNSPECIFIED 
SD
HD
UHD:\\�AY
livestream.googleapis.com/Input6projects/{project}/locations/{location}/inputs/{input}"�
Channel
name (	4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AE
labels (25.google.cloud.video.livestream.v1.Channel.LabelsEntryL
input_attachments (21.google.cloud.video.livestream.v1.InputAttachment
active_input (	B�AE
output	 (20.google.cloud.video.livestream.v1.Channel.OutputB�AN
elementary_streams
 (22.google.cloud.video.livestream.v1.ElementaryStream@
mux_streams (2+.google.cloud.video.livestream.v1.MuxStream=
	manifests (2*.google.cloud.video.livestream.v1.ManifestD
sprite_sheets (2-.google.cloud.video.livestream.v1.SpriteSheetV
streaming_state (28.google.cloud.video.livestream.v1.Channel.StreamingStateB�A0
streaming_error (2.google.rpc.StatusB�A?

log_config (2+.google.cloud.video.livestream.v1.LogConfigI
timecode_config (20.google.cloud.video.livestream.v1.TimecodeConfigA
encryptions (2,.google.cloud.video.livestream.v1.EncryptionC
input_config (2-.google.cloud.video.livestream.v1.InputConfigP
retention_config (21.google.cloud.video.livestream.v1.RetentionConfigB�AM
static_overlays (2/.google.cloud.video.livestream.v1.StaticOverlayB�A
Output
uri (	-
LabelsEntry
key (	
value (	:8"�
StreamingState
STREAMING_STATE_UNSPECIFIED 
	STREAMING
AWAITING_INPUT
STREAMING_ERROR
STREAMING_NO_INPUT
STOPPED
STARTING
STOPPING:b�A_
!livestream.googleapis.com/Channel:projects/{project}/locations/{location}/channels/{channel}"6
NormalizedCoordinate
x (B�A
y (B�A"6
NormalizedResolution
w (B�A
h (B�A"�
StaticOverlay6
asset (	B\'�A�A!
livestream.googleapis.com/AssetO

resolution (26.google.cloud.video.livestream.v1.NormalizedResolutionB�AM
position (26.google.cloud.video.livestream.v1.NormalizedCoordinateB�A
opacity (B�A"�
InputConfigX
input_switch_mode (2=.google.cloud.video.livestream.v1.InputConfig.InputSwitchMode"]
InputSwitchMode!
INPUT_SWITCH_MODE_UNSPECIFIED 
FAILOVER_PREFER_PRIMARY

MANUAL"�
	LogConfigM
log_severity (27.google.cloud.video.livestream.v1.LogConfig.LogSeverity"d
LogSeverity
LOG_SEVERITY_UNSPECIFIED 
OFF	
DEBUGd	
INFO�
WARNING�

ERROR�"O
RetentionConfig<
retention_window_duration (2.google.protobuf.Duration"�
InputStreamProperty7
last_establish_time (2.google.protobuf.TimestampL
video_streams (25.google.cloud.video.livestream.v1.VideoStreamPropertyL
audio_streams (25.google.cloud.video.livestream.v1.AudioStreamProperty"i
VideoStreamProperty
index (C
video_format (2-.google.cloud.video.livestream.v1.VideoFormat"]
VideoFormat
codec (	
width_pixels (
height_pixels (

frame_rate ("i
AudioStreamProperty
index (C
audio_format (2-.google.cloud.video.livestream.v1.AudioFormat"K
AudioFormat
codec (	
channel_count (
channel_layout (	"�
InputAttachment
key (	3
input (	B$�A!
livestream.googleapis.com/Input_
automatic_failover (2C.google.cloud.video.livestream.v1.InputAttachment.AutomaticFailover\'
AutomaticFailover

input_keys (	"�
Event
name (	4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AC
labels (23.google.cloud.video.livestream.v1.Event.LabelsEntryO
input_switch (27.google.cloud.video.livestream.v1.Event.InputSwitchTaskH G
ad_break (23.google.cloud.video.livestream.v1.Event.AdBreakTaskH X
return_to_program (2;.google.cloud.video.livestream.v1.Event.ReturnToProgramTaskH B
slate (21.google.cloud.video.livestream.v1.Event.SlateTaskH @
mute (20.google.cloud.video.livestream.v1.Event.MuteTaskH D
unmute (22.google.cloud.video.livestream.v1.Event.UnmuteTaskH 
execute_now	 (2
execution_time
 (2.google.protobuf.TimestampA
state (2-.google.cloud.video.livestream.v1.Event.StateB�A&
error (2.google.rpc.StatusB�A$
InputSwitchTask
	input_key (	:
AdBreakTask+
duration (2.google.protobuf.Durationm
	SlateTask+
duration (2.google.protobuf.Duration3
asset (	B$�A!
livestream.googleapis.com/Asset
ReturnToProgramTask7
MuteTask+
duration (2.google.protobuf.Duration

UnmuteTask-
LabelsEntry
key (	
value (	:8"o
State
STATE_UNSPECIFIED 
	SCHEDULED
RUNNING
	SUCCEEDED

FAILED
PENDING
STOPPED:o�Al
livestream.googleapis.com/EventIprojects/{project}/locations/{location}/channels/{channel}/events/{event}B
task"�	
Clip
name (	4
create_time (2.google.protobuf.TimestampB�A3

start_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AB
labels (22.google.cloud.video.livestream.v1.Clip.LabelsEntry@
state (2,.google.cloud.video.livestream.v1.Clip.StateB�A

output_uri (	&
error	 (2.google.rpc.StatusB�A<
slices
 (2,.google.cloud.video.livestream.v1.Clip.SliceP
clip_manifests (23.google.cloud.video.livestream.v1.Clip.ClipManifestB�AK
output_type (21.google.cloud.video.livestream.v1.Clip.OutputTypeB�An
	TimeSlice/
markin_time (2.google.protobuf.Timestamp0
markout_time (2.google.protobuf.TimestampW
SliceF

time_slice (20.google.cloud.video.livestream.v1.Clip.TimeSliceH B
kindB
ClipManifest
manifest_key (	B�A

output_uri (	B�A-
LabelsEntry
key (	
value (	:8"T
State
STATE_UNSPECIFIED 
PENDING
CREATING
	SUCCEEDED

FAILED"@

OutputType
OUTPUT_TYPE_UNSPECIFIED 
MANIFEST
MP4:l�Ai
livestream.googleapis.com/ClipGprojects/{project}/locations/{location}/channels/{channel}/clips/{clip}"v
TimeInterval3

start_time (2.google.protobuf.TimestampB�A1
end_time (2.google.protobuf.TimestampB�A"�

DvrSession
name (	B�A4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AM
labels (28.google.cloud.video.livestream.v1.DvrSession.LabelsEntryB�AF
state (22.google.cloud.video.livestream.v1.DvrSession.StateB�A&
error (2.google.rpc.StatusB�AT
dvr_manifests (28.google.cloud.video.livestream.v1.DvrSession.DvrManifestB�AP
dvr_windows (26.google.cloud.video.livestream.v1.DvrSession.DvrWindowB�AA
DvrManifest
manifest_key (	B�A

output_uri (	B�A\\
	DvrWindowG
time_interval (2..google.cloud.video.livestream.v1.TimeIntervalH B
kind-
LabelsEntry
key (	
value (	:8"�
State
STATE_UNSPECIFIED 
PENDING
UPDATING
	SCHEDULED
LIVE
FINISHED

FAILED
DELETING
POST_PROCESSING
COOLDOWN	
STOPPING
:��A�
$livestream.googleapis.com/DvrSessionTprojects/{project}/locations/{location}/channels/{channel}/dvrSessions/{dvr_session}*dvrSessions2
dvrSession"�
Asset
name (	4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AC
labels (23.google.cloud.video.livestream.v1.Asset.LabelsEntryC
video (22.google.cloud.video.livestream.v1.Asset.VideoAssetH C
image (22.google.cloud.video.livestream.v1.Asset.ImageAssetH 
crc32c (	A
state (2-.google.cloud.video.livestream.v1.Asset.StateB�A&
error	 (2.google.rpc.StatusB�A

VideoAsset
uri (	

ImageAsset
uri (	-
LabelsEntry
key (	
value (	:8"Q
State
STATE_UNSPECIFIED 
CREATING

ACTIVE
DELETING	
ERROR:\\�AY
livestream.googleapis.com/Asset6projects/{project}/locations/{location}/assets/{asset}B

resource"�

Encryption
id (	B�Ae
secret_manager_key_source (2@.google.cloud.video.livestream.v1.Encryption.SecretManagerSourceH Q
drm_systems (27.google.cloud.video.livestream.v1.Encryption.DrmSystemsB�AO
aes128 (2=.google.cloud.video.livestream.v1.Encryption.Aes128EncryptionHV

sample_aes (2@.google.cloud.video.livestream.v1.Encryption.SampleAesEncryptionHV
	mpeg_cenc (2A.google.cloud.video.livestream.v1.Encryption.MpegCommonEncryptionHa
SecretManagerSourceJ
secret_version (	B2�A�A,
*secretmanager.googleapis.com/SecretVersion

Widevine

Fairplay
	Playready

Clearkey�

DrmSystemsG
widevine (25.google.cloud.video.livestream.v1.Encryption.WidevineG
fairplay (25.google.cloud.video.livestream.v1.Encryption.FairplayI
	playready (26.google.cloud.video.livestream.v1.Encryption.PlayreadyG
clearkey (25.google.cloud.video.livestream.v1.Encryption.Clearkey
Aes128Encryption
SampleAesEncryption+
MpegCommonEncryption
scheme (	B�AB
secret_sourceB
encryption_mode"�
Pool
name (	4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AB
labels (22.google.cloud.video.livestream.v1.Pool.LabelsEntryL
network_config (24.google.cloud.video.livestream.v1.Pool.NetworkConfigL
NetworkConfig;
peered_network (	B#�A 
compute.googleapis.com/Network-
LabelsEntry
key (	
value (	:8:Y�AV
livestream.googleapis.com/Pool4projects/{project}/locations/{location}/pools/{pool}B�
$com.google.cloud.video.livestream.v1BResourcesProtoPZDcloud.google.com/go/video/livestream/apiv1/livestreampb;livestreampb� Google.Cloud.Video.LiveStream.V1� Google\\Cloud\\Video\\LiveStream\\V1�$Google::Cloud::Video::LiveStream::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

