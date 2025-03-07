<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/dataflow/v1beta3/environment.proto

namespace Google\Cloud\Dataflow\V1beta3;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Taskrunner configuration settings.
 *
 * Generated from protobuf message <code>google.dataflow.v1beta3.TaskRunnerSettings</code>
 */
class TaskRunnerSettings extends \Google\Protobuf\Internal\Message
{
    /**
     * The UNIX user ID on the worker VM to use for tasks launched by
     * taskrunner; e.g. "root".
     *
     * Generated from protobuf field <code>string task_user = 1;</code>
     */
    protected $task_user = '';
    /**
     * The UNIX group ID on the worker VM to use for tasks launched by
     * taskrunner; e.g. "wheel".
     *
     * Generated from protobuf field <code>string task_group = 2;</code>
     */
    protected $task_group = '';
    /**
     * The OAuth2 scopes to be requested by the taskrunner in order to
     * access the Cloud Dataflow API.
     *
     * Generated from protobuf field <code>repeated string oauth_scopes = 3;</code>
     */
    private $oauth_scopes;
    /**
     * The base URL for the taskrunner to use when accessing Google Cloud APIs.
     * When workers access Google Cloud APIs, they logically do so via
     * relative URLs.  If this field is specified, it supplies the base
     * URL to use for resolving these relative URLs.  The normative
     * algorithm used is defined by RFC 1808, "Relative Uniform Resource
     * Locators".
     * If not specified, the default value is "http://www.googleapis.com/"
     *
     * Generated from protobuf field <code>string base_url = 4;</code>
     */
    protected $base_url = '';
    /**
     * The API version of endpoint, e.g. "v1b3"
     *
     * Generated from protobuf field <code>string dataflow_api_version = 5;</code>
     */
    protected $dataflow_api_version = '';
    /**
     * The settings to pass to the parallel worker harness.
     *
     * Generated from protobuf field <code>.google.dataflow.v1beta3.WorkerSettings parallel_worker_settings = 6;</code>
     */
    protected $parallel_worker_settings = null;
    /**
     * The location on the worker for task-specific subdirectories.
     *
     * Generated from protobuf field <code>string base_task_dir = 7;</code>
     */
    protected $base_task_dir = '';
    /**
     * Whether to continue taskrunner if an exception is hit.
     *
     * Generated from protobuf field <code>bool continue_on_exception = 8;</code>
     */
    protected $continue_on_exception = false;
    /**
     * Whether to send taskrunner log info to Google Compute Engine VM serial
     * console.
     *
     * Generated from protobuf field <code>bool log_to_serialconsole = 9;</code>
     */
    protected $log_to_serialconsole = false;
    /**
     * Whether to also send taskrunner log info to stderr.
     *
     * Generated from protobuf field <code>bool alsologtostderr = 10;</code>
     */
    protected $alsologtostderr = false;
    /**
     * Indicates where to put logs.  If this is not specified, the logs
     * will not be uploaded.
     * The supported resource type is:
     * Google Cloud Storage:
     *   storage.googleapis.com/{bucket}/{object}
     *   bucket.storage.googleapis.com/{object}
     *
     * Generated from protobuf field <code>string log_upload_location = 11;</code>
     */
    protected $log_upload_location = '';
    /**
     * The directory on the VM to store logs.
     *
     * Generated from protobuf field <code>string log_dir = 12;</code>
     */
    protected $log_dir = '';
    /**
     * The prefix of the resources the taskrunner should use for
     * temporary storage.
     * The supported resource type is:
     * Google Cloud Storage:
     *   storage.googleapis.com/{bucket}/{object}
     *   bucket.storage.googleapis.com/{object}
     *
     * Generated from protobuf field <code>string temp_storage_prefix = 13;</code>
     */
    protected $temp_storage_prefix = '';
    /**
     * The command to launch the worker harness.
     *
     * Generated from protobuf field <code>string harness_command = 14;</code>
     */
    protected $harness_command = '';
    /**
     * The file to store the workflow in.
     *
     * Generated from protobuf field <code>string workflow_file_name = 15;</code>
     */
    protected $workflow_file_name = '';
    /**
     * The file to store preprocessing commands in.
     *
     * Generated from protobuf field <code>string commandlines_file_name = 16;</code>
     */
    protected $commandlines_file_name = '';
    /**
     * The ID string of the VM.
     *
     * Generated from protobuf field <code>string vm_id = 17;</code>
     */
    protected $vm_id = '';
    /**
     * The suggested backend language.
     *
     * Generated from protobuf field <code>string language_hint = 18;</code>
     */
    protected $language_hint = '';
    /**
     * The streaming worker main class name.
     *
     * Generated from protobuf field <code>string streaming_worker_main_class = 19;</code>
     */
    protected $streaming_worker_main_class = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $task_user
     *           The UNIX user ID on the worker VM to use for tasks launched by
     *           taskrunner; e.g. "root".
     *     @type string $task_group
     *           The UNIX group ID on the worker VM to use for tasks launched by
     *           taskrunner; e.g. "wheel".
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $oauth_scopes
     *           The OAuth2 scopes to be requested by the taskrunner in order to
     *           access the Cloud Dataflow API.
     *     @type string $base_url
     *           The base URL for the taskrunner to use when accessing Google Cloud APIs.
     *           When workers access Google Cloud APIs, they logically do so via
     *           relative URLs.  If this field is specified, it supplies the base
     *           URL to use for resolving these relative URLs.  The normative
     *           algorithm used is defined by RFC 1808, "Relative Uniform Resource
     *           Locators".
     *           If not specified, the default value is "http://www.googleapis.com/"
     *     @type string $dataflow_api_version
     *           The API version of endpoint, e.g. "v1b3"
     *     @type \Google\Cloud\Dataflow\V1beta3\WorkerSettings $parallel_worker_settings
     *           The settings to pass to the parallel worker harness.
     *     @type string $base_task_dir
     *           The location on the worker for task-specific subdirectories.
     *     @type bool $continue_on_exception
     *           Whether to continue taskrunner if an exception is hit.
     *     @type bool $log_to_serialconsole
     *           Whether to send taskrunner log info to Google Compute Engine VM serial
     *           console.
     *     @type bool $alsologtostderr
     *           Whether to also send taskrunner log info to stderr.
     *     @type string $log_upload_location
     *           Indicates where to put logs.  If this is not specified, the logs
     *           will not be uploaded.
     *           The supported resource type is:
     *           Google Cloud Storage:
     *             storage.googleapis.com/{bucket}/{object}
     *             bucket.storage.googleapis.com/{object}
     *     @type string $log_dir
     *           The directory on the VM to store logs.
     *     @type string $temp_storage_prefix
     *           The prefix of the resources the taskrunner should use for
     *           temporary storage.
     *           The supported resource type is:
     *           Google Cloud Storage:
     *             storage.googleapis.com/{bucket}/{object}
     *             bucket.storage.googleapis.com/{object}
     *     @type string $harness_command
     *           The command to launch the worker harness.
     *     @type string $workflow_file_name
     *           The file to store the workflow in.
     *     @type string $commandlines_file_name
     *           The file to store preprocessing commands in.
     *     @type string $vm_id
     *           The ID string of the VM.
     *     @type string $language_hint
     *           The suggested backend language.
     *     @type string $streaming_worker_main_class
     *           The streaming worker main class name.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Dataflow\V1Beta3\Environment::initOnce();
        parent::__construct($data);
    }

    /**
     * The UNIX user ID on the worker VM to use for tasks launched by
     * taskrunner; e.g. "root".
     *
     * Generated from protobuf field <code>string task_user = 1;</code>
     * @return string
     */
    public function getTaskUser()
    {
        return $this->task_user;
    }

    /**
     * The UNIX user ID on the worker VM to use for tasks launched by
     * taskrunner; e.g. "root".
     *
     * Generated from protobuf field <code>string task_user = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setTaskUser($var)
    {
        GPBUtil::checkString($var, True);
        $this->task_user = $var;

        return $this;
    }

    /**
     * The UNIX group ID on the worker VM to use for tasks launched by
     * taskrunner; e.g. "wheel".
     *
     * Generated from protobuf field <code>string task_group = 2;</code>
     * @return string
     */
    public function getTaskGroup()
    {
        return $this->task_group;
    }

    /**
     * The UNIX group ID on the worker VM to use for tasks launched by
     * taskrunner; e.g. "wheel".
     *
     * Generated from protobuf field <code>string task_group = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setTaskGroup($var)
    {
        GPBUtil::checkString($var, True);
        $this->task_group = $var;

        return $this;
    }

    /**
     * The OAuth2 scopes to be requested by the taskrunner in order to
     * access the Cloud Dataflow API.
     *
     * Generated from protobuf field <code>repeated string oauth_scopes = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getOauthScopes()
    {
        return $this->oauth_scopes;
    }

    /**
     * The OAuth2 scopes to be requested by the taskrunner in order to
     * access the Cloud Dataflow API.
     *
     * Generated from protobuf field <code>repeated string oauth_scopes = 3;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setOauthScopes($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->oauth_scopes = $arr;

        return $this;
    }

    /**
     * The base URL for the taskrunner to use when accessing Google Cloud APIs.
     * When workers access Google Cloud APIs, they logically do so via
     * relative URLs.  If this field is specified, it supplies the base
     * URL to use for resolving these relative URLs.  The normative
     * algorithm used is defined by RFC 1808, "Relative Uniform Resource
     * Locators".
     * If not specified, the default value is "http://www.googleapis.com/"
     *
     * Generated from protobuf field <code>string base_url = 4;</code>
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->base_url;
    }

    /**
     * The base URL for the taskrunner to use when accessing Google Cloud APIs.
     * When workers access Google Cloud APIs, they logically do so via
     * relative URLs.  If this field is specified, it supplies the base
     * URL to use for resolving these relative URLs.  The normative
     * algorithm used is defined by RFC 1808, "Relative Uniform Resource
     * Locators".
     * If not specified, the default value is "http://www.googleapis.com/"
     *
     * Generated from protobuf field <code>string base_url = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setBaseUrl($var)
    {
        GPBUtil::checkString($var, True);
        $this->base_url = $var;

        return $this;
    }

    /**
     * The API version of endpoint, e.g. "v1b3"
     *
     * Generated from protobuf field <code>string dataflow_api_version = 5;</code>
     * @return string
     */
    public function getDataflowApiVersion()
    {
        return $this->dataflow_api_version;
    }

    /**
     * The API version of endpoint, e.g. "v1b3"
     *
     * Generated from protobuf field <code>string dataflow_api_version = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setDataflowApiVersion($var)
    {
        GPBUtil::checkString($var, True);
        $this->dataflow_api_version = $var;

        return $this;
    }

    /**
     * The settings to pass to the parallel worker harness.
     *
     * Generated from protobuf field <code>.google.dataflow.v1beta3.WorkerSettings parallel_worker_settings = 6;</code>
     * @return \Google\Cloud\Dataflow\V1beta3\WorkerSettings|null
     */
    public function getParallelWorkerSettings()
    {
        return $this->parallel_worker_settings;
    }

    public function hasParallelWorkerSettings()
    {
        return isset($this->parallel_worker_settings);
    }

    public function clearParallelWorkerSettings()
    {
        unset($this->parallel_worker_settings);
    }

    /**
     * The settings to pass to the parallel worker harness.
     *
     * Generated from protobuf field <code>.google.dataflow.v1beta3.WorkerSettings parallel_worker_settings = 6;</code>
     * @param \Google\Cloud\Dataflow\V1beta3\WorkerSettings $var
     * @return $this
     */
    public function setParallelWorkerSettings($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dataflow\V1beta3\WorkerSettings::class);
        $this->parallel_worker_settings = $var;

        return $this;
    }

    /**
     * The location on the worker for task-specific subdirectories.
     *
     * Generated from protobuf field <code>string base_task_dir = 7;</code>
     * @return string
     */
    public function getBaseTaskDir()
    {
        return $this->base_task_dir;
    }

    /**
     * The location on the worker for task-specific subdirectories.
     *
     * Generated from protobuf field <code>string base_task_dir = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setBaseTaskDir($var)
    {
        GPBUtil::checkString($var, True);
        $this->base_task_dir = $var;

        return $this;
    }

    /**
     * Whether to continue taskrunner if an exception is hit.
     *
     * Generated from protobuf field <code>bool continue_on_exception = 8;</code>
     * @return bool
     */
    public function getContinueOnException()
    {
        return $this->continue_on_exception;
    }

    /**
     * Whether to continue taskrunner if an exception is hit.
     *
     * Generated from protobuf field <code>bool continue_on_exception = 8;</code>
     * @param bool $var
     * @return $this
     */
    public function setContinueOnException($var)
    {
        GPBUtil::checkBool($var);
        $this->continue_on_exception = $var;

        return $this;
    }

    /**
     * Whether to send taskrunner log info to Google Compute Engine VM serial
     * console.
     *
     * Generated from protobuf field <code>bool log_to_serialconsole = 9;</code>
     * @return bool
     */
    public function getLogToSerialconsole()
    {
        return $this->log_to_serialconsole;
    }

    /**
     * Whether to send taskrunner log info to Google Compute Engine VM serial
     * console.
     *
     * Generated from protobuf field <code>bool log_to_serialconsole = 9;</code>
     * @param bool $var
     * @return $this
     */
    public function setLogToSerialconsole($var)
    {
        GPBUtil::checkBool($var);
        $this->log_to_serialconsole = $var;

        return $this;
    }

    /**
     * Whether to also send taskrunner log info to stderr.
     *
     * Generated from protobuf field <code>bool alsologtostderr = 10;</code>
     * @return bool
     */
    public function getAlsologtostderr()
    {
        return $this->alsologtostderr;
    }

    /**
     * Whether to also send taskrunner log info to stderr.
     *
     * Generated from protobuf field <code>bool alsologtostderr = 10;</code>
     * @param bool $var
     * @return $this
     */
    public function setAlsologtostderr($var)
    {
        GPBUtil::checkBool($var);
        $this->alsologtostderr = $var;

        return $this;
    }

    /**
     * Indicates where to put logs.  If this is not specified, the logs
     * will not be uploaded.
     * The supported resource type is:
     * Google Cloud Storage:
     *   storage.googleapis.com/{bucket}/{object}
     *   bucket.storage.googleapis.com/{object}
     *
     * Generated from protobuf field <code>string log_upload_location = 11;</code>
     * @return string
     */
    public function getLogUploadLocation()
    {
        return $this->log_upload_location;
    }

    /**
     * Indicates where to put logs.  If this is not specified, the logs
     * will not be uploaded.
     * The supported resource type is:
     * Google Cloud Storage:
     *   storage.googleapis.com/{bucket}/{object}
     *   bucket.storage.googleapis.com/{object}
     *
     * Generated from protobuf field <code>string log_upload_location = 11;</code>
     * @param string $var
     * @return $this
     */
    public function setLogUploadLocation($var)
    {
        GPBUtil::checkString($var, True);
        $this->log_upload_location = $var;

        return $this;
    }

    /**
     * The directory on the VM to store logs.
     *
     * Generated from protobuf field <code>string log_dir = 12;</code>
     * @return string
     */
    public function getLogDir()
    {
        return $this->log_dir;
    }

    /**
     * The directory on the VM to store logs.
     *
     * Generated from protobuf field <code>string log_dir = 12;</code>
     * @param string $var
     * @return $this
     */
    public function setLogDir($var)
    {
        GPBUtil::checkString($var, True);
        $this->log_dir = $var;

        return $this;
    }

    /**
     * The prefix of the resources the taskrunner should use for
     * temporary storage.
     * The supported resource type is:
     * Google Cloud Storage:
     *   storage.googleapis.com/{bucket}/{object}
     *   bucket.storage.googleapis.com/{object}
     *
     * Generated from protobuf field <code>string temp_storage_prefix = 13;</code>
     * @return string
     */
    public function getTempStoragePrefix()
    {
        return $this->temp_storage_prefix;
    }

    /**
     * The prefix of the resources the taskrunner should use for
     * temporary storage.
     * The supported resource type is:
     * Google Cloud Storage:
     *   storage.googleapis.com/{bucket}/{object}
     *   bucket.storage.googleapis.com/{object}
     *
     * Generated from protobuf field <code>string temp_storage_prefix = 13;</code>
     * @param string $var
     * @return $this
     */
    public function setTempStoragePrefix($var)
    {
        GPBUtil::checkString($var, True);
        $this->temp_storage_prefix = $var;

        return $this;
    }

    /**
     * The command to launch the worker harness.
     *
     * Generated from protobuf field <code>string harness_command = 14;</code>
     * @return string
     */
    public function getHarnessCommand()
    {
        return $this->harness_command;
    }

    /**
     * The command to launch the worker harness.
     *
     * Generated from protobuf field <code>string harness_command = 14;</code>
     * @param string $var
     * @return $this
     */
    public function setHarnessCommand($var)
    {
        GPBUtil::checkString($var, True);
        $this->harness_command = $var;

        return $this;
    }

    /**
     * The file to store the workflow in.
     *
     * Generated from protobuf field <code>string workflow_file_name = 15;</code>
     * @return string
     */
    public function getWorkflowFileName()
    {
        return $this->workflow_file_name;
    }

    /**
     * The file to store the workflow in.
     *
     * Generated from protobuf field <code>string workflow_file_name = 15;</code>
     * @param string $var
     * @return $this
     */
    public function setWorkflowFileName($var)
    {
        GPBUtil::checkString($var, True);
        $this->workflow_file_name = $var;

        return $this;
    }

    /**
     * The file to store preprocessing commands in.
     *
     * Generated from protobuf field <code>string commandlines_file_name = 16;</code>
     * @return string
     */
    public function getCommandlinesFileName()
    {
        return $this->commandlines_file_name;
    }

    /**
     * The file to store preprocessing commands in.
     *
     * Generated from protobuf field <code>string commandlines_file_name = 16;</code>
     * @param string $var
     * @return $this
     */
    public function setCommandlinesFileName($var)
    {
        GPBUtil::checkString($var, True);
        $this->commandlines_file_name = $var;

        return $this;
    }

    /**
     * The ID string of the VM.
     *
     * Generated from protobuf field <code>string vm_id = 17;</code>
     * @return string
     */
    public function getVmId()
    {
        return $this->vm_id;
    }

    /**
     * The ID string of the VM.
     *
     * Generated from protobuf field <code>string vm_id = 17;</code>
     * @param string $var
     * @return $this
     */
    public function setVmId($var)
    {
        GPBUtil::checkString($var, True);
        $this->vm_id = $var;

        return $this;
    }

    /**
     * The suggested backend language.
     *
     * Generated from protobuf field <code>string language_hint = 18;</code>
     * @return string
     */
    public function getLanguageHint()
    {
        return $this->language_hint;
    }

    /**
     * The suggested backend language.
     *
     * Generated from protobuf field <code>string language_hint = 18;</code>
     * @param string $var
     * @return $this
     */
    public function setLanguageHint($var)
    {
        GPBUtil::checkString($var, True);
        $this->language_hint = $var;

        return $this;
    }

    /**
     * The streaming worker main class name.
     *
     * Generated from protobuf field <code>string streaming_worker_main_class = 19;</code>
     * @return string
     */
    public function getStreamingWorkerMainClass()
    {
        return $this->streaming_worker_main_class;
    }

    /**
     * The streaming worker main class name.
     *
     * Generated from protobuf field <code>string streaming_worker_main_class = 19;</code>
     * @param string $var
     * @return $this
     */
    public function setStreamingWorkerMainClass($var)
    {
        GPBUtil::checkString($var, True);
        $this->streaming_worker_main_class = $var;

        return $this;
    }

}

