<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/batch/v1/task.proto

namespace Google\Cloud\Batch\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Compute resource requirements.
 * ComputeResource defines the amount of resources required for each task.
 * Make sure your tasks have enough resources to successfully run.
 * If you also define the types of resources for a job to use with the
 * [InstancePolicyOrTemplate](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicyortemplate)
 * field, make sure both fields are compatible with each other.
 *
 * Generated from protobuf message <code>google.cloud.batch.v1.ComputeResource</code>
 */
class ComputeResource extends \Google\Protobuf\Internal\Message
{
    /**
     * The milliCPU count.
     * `cpuMilli` defines the amount of CPU resources per task in milliCPU units.
     * For example, `1000` corresponds to 1 vCPU per task. If undefined, the
     * default value is `2000`.
     * If you also define the VM's machine type using the `machineType` in
     * [InstancePolicy](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicy)
     * field or inside the `instanceTemplate` in the
     * [InstancePolicyOrTemplate](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicyortemplate)
     * field, make sure the CPU resources for both fields are compatible with each
     * other and with how many tasks you want to allow to run on the same VM at
     * the same time.
     * For example, if you specify the `n2-standard-2` machine type, which has 2
     * vCPUs each, you are recommended to set `cpuMilli` no more than `2000`, or
     * you are recommended to run two tasks on the same VM if you set `cpuMilli`
     * to `1000` or less.
     *
     * Generated from protobuf field <code>int64 cpu_milli = 1;</code>
     */
    protected $cpu_milli = 0;
    /**
     * Memory in MiB.
     * `memoryMib` defines the amount of memory per task in MiB units.
     * If undefined, the default value is `2000`.
     * If you also define the VM's machine type using the `machineType` in
     * [InstancePolicy](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicy)
     * field or inside the `instanceTemplate` in the
     * [InstancePolicyOrTemplate](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicyortemplate)
     * field, make sure the memory resources for both fields are compatible with
     * each other and with how many tasks you want to allow to run on the same VM
     * at the same time.
     * For example, if you specify the `n2-standard-2` machine type, which has 8
     * GiB each, you are recommended to set `memoryMib` to no more than `8192`,
     * or you are recommended to run two tasks on the same VM if you set
     * `memoryMib` to `4096` or less.
     *
     * Generated from protobuf field <code>int64 memory_mib = 2;</code>
     */
    protected $memory_mib = 0;
    /**
     * Extra boot disk size in MiB for each task.
     *
     * Generated from protobuf field <code>int64 boot_disk_mib = 4;</code>
     */
    protected $boot_disk_mib = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $cpu_milli
     *           The milliCPU count.
     *           `cpuMilli` defines the amount of CPU resources per task in milliCPU units.
     *           For example, `1000` corresponds to 1 vCPU per task. If undefined, the
     *           default value is `2000`.
     *           If you also define the VM's machine type using the `machineType` in
     *           [InstancePolicy](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicy)
     *           field or inside the `instanceTemplate` in the
     *           [InstancePolicyOrTemplate](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicyortemplate)
     *           field, make sure the CPU resources for both fields are compatible with each
     *           other and with how many tasks you want to allow to run on the same VM at
     *           the same time.
     *           For example, if you specify the `n2-standard-2` machine type, which has 2
     *           vCPUs each, you are recommended to set `cpuMilli` no more than `2000`, or
     *           you are recommended to run two tasks on the same VM if you set `cpuMilli`
     *           to `1000` or less.
     *     @type int|string $memory_mib
     *           Memory in MiB.
     *           `memoryMib` defines the amount of memory per task in MiB units.
     *           If undefined, the default value is `2000`.
     *           If you also define the VM's machine type using the `machineType` in
     *           [InstancePolicy](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicy)
     *           field or inside the `instanceTemplate` in the
     *           [InstancePolicyOrTemplate](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicyortemplate)
     *           field, make sure the memory resources for both fields are compatible with
     *           each other and with how many tasks you want to allow to run on the same VM
     *           at the same time.
     *           For example, if you specify the `n2-standard-2` machine type, which has 8
     *           GiB each, you are recommended to set `memoryMib` to no more than `8192`,
     *           or you are recommended to run two tasks on the same VM if you set
     *           `memoryMib` to `4096` or less.
     *     @type int|string $boot_disk_mib
     *           Extra boot disk size in MiB for each task.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Batch\V1\Task::initOnce();
        parent::__construct($data);
    }

    /**
     * The milliCPU count.
     * `cpuMilli` defines the amount of CPU resources per task in milliCPU units.
     * For example, `1000` corresponds to 1 vCPU per task. If undefined, the
     * default value is `2000`.
     * If you also define the VM's machine type using the `machineType` in
     * [InstancePolicy](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicy)
     * field or inside the `instanceTemplate` in the
     * [InstancePolicyOrTemplate](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicyortemplate)
     * field, make sure the CPU resources for both fields are compatible with each
     * other and with how many tasks you want to allow to run on the same VM at
     * the same time.
     * For example, if you specify the `n2-standard-2` machine type, which has 2
     * vCPUs each, you are recommended to set `cpuMilli` no more than `2000`, or
     * you are recommended to run two tasks on the same VM if you set `cpuMilli`
     * to `1000` or less.
     *
     * Generated from protobuf field <code>int64 cpu_milli = 1;</code>
     * @return int|string
     */
    public function getCpuMilli()
    {
        return $this->cpu_milli;
    }

    /**
     * The milliCPU count.
     * `cpuMilli` defines the amount of CPU resources per task in milliCPU units.
     * For example, `1000` corresponds to 1 vCPU per task. If undefined, the
     * default value is `2000`.
     * If you also define the VM's machine type using the `machineType` in
     * [InstancePolicy](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicy)
     * field or inside the `instanceTemplate` in the
     * [InstancePolicyOrTemplate](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicyortemplate)
     * field, make sure the CPU resources for both fields are compatible with each
     * other and with how many tasks you want to allow to run on the same VM at
     * the same time.
     * For example, if you specify the `n2-standard-2` machine type, which has 2
     * vCPUs each, you are recommended to set `cpuMilli` no more than `2000`, or
     * you are recommended to run two tasks on the same VM if you set `cpuMilli`
     * to `1000` or less.
     *
     * Generated from protobuf field <code>int64 cpu_milli = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setCpuMilli($var)
    {
        GPBUtil::checkInt64($var);
        $this->cpu_milli = $var;

        return $this;
    }

    /**
     * Memory in MiB.
     * `memoryMib` defines the amount of memory per task in MiB units.
     * If undefined, the default value is `2000`.
     * If you also define the VM's machine type using the `machineType` in
     * [InstancePolicy](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicy)
     * field or inside the `instanceTemplate` in the
     * [InstancePolicyOrTemplate](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicyortemplate)
     * field, make sure the memory resources for both fields are compatible with
     * each other and with how many tasks you want to allow to run on the same VM
     * at the same time.
     * For example, if you specify the `n2-standard-2` machine type, which has 8
     * GiB each, you are recommended to set `memoryMib` to no more than `8192`,
     * or you are recommended to run two tasks on the same VM if you set
     * `memoryMib` to `4096` or less.
     *
     * Generated from protobuf field <code>int64 memory_mib = 2;</code>
     * @return int|string
     */
    public function getMemoryMib()
    {
        return $this->memory_mib;
    }

    /**
     * Memory in MiB.
     * `memoryMib` defines the amount of memory per task in MiB units.
     * If undefined, the default value is `2000`.
     * If you also define the VM's machine type using the `machineType` in
     * [InstancePolicy](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicy)
     * field or inside the `instanceTemplate` in the
     * [InstancePolicyOrTemplate](https://cloud.google.com/batch/docs/reference/rest/v1/projects.locations.jobs#instancepolicyortemplate)
     * field, make sure the memory resources for both fields are compatible with
     * each other and with how many tasks you want to allow to run on the same VM
     * at the same time.
     * For example, if you specify the `n2-standard-2` machine type, which has 8
     * GiB each, you are recommended to set `memoryMib` to no more than `8192`,
     * or you are recommended to run two tasks on the same VM if you set
     * `memoryMib` to `4096` or less.
     *
     * Generated from protobuf field <code>int64 memory_mib = 2;</code>
     * @param int|string $var
     * @return $this
     */
    public function setMemoryMib($var)
    {
        GPBUtil::checkInt64($var);
        $this->memory_mib = $var;

        return $this;
    }

    /**
     * Extra boot disk size in MiB for each task.
     *
     * Generated from protobuf field <code>int64 boot_disk_mib = 4;</code>
     * @return int|string
     */
    public function getBootDiskMib()
    {
        return $this->boot_disk_mib;
    }

    /**
     * Extra boot disk size in MiB for each task.
     *
     * Generated from protobuf field <code>int64 boot_disk_mib = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setBootDiskMib($var)
    {
        GPBUtil::checkInt64($var);
        $this->boot_disk_mib = $var;

        return $this;
    }

}

