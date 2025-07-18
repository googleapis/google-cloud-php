<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/admanager/v1/report_messages.proto

namespace Google\Ads\AdManager\V1\Report\DateRange;

use UnexpectedValueException;

/**
 * Options for relative date ranges.
 *
 * Protobuf type <code>google.ads.admanager.v1.Report.DateRange.RelativeDateRange</code>
 */
class RelativeDateRange
{
    /**
     * Default value. This value is unused.
     *
     * Generated from protobuf enum <code>RELATIVE_DATE_RANGE_UNSPECIFIED = 0;</code>
     */
    const RELATIVE_DATE_RANGE_UNSPECIFIED = 0;
    /**
     * The date the report is run.
     *
     * Generated from protobuf enum <code>TODAY = 1;</code>
     */
    const TODAY = 1;
    /**
     * The date a day before the date that the report is run.
     *
     * Generated from protobuf enum <code>YESTERDAY = 2;</code>
     */
    const YESTERDAY = 2;
    /**
     * The full week in which this report is run. Could include dates in
     * the future.
     *
     * Generated from protobuf enum <code>THIS_WEEK = 3;</code>
     */
    const THIS_WEEK = 3;
    /**
     * From the beginning of the calendar week (Monday to Sunday) in which the
     * up to and including the day the report is run.
     *
     * Generated from protobuf enum <code>THIS_WEEK_TO_DATE = 29;</code>
     */
    const THIS_WEEK_TO_DATE = 29;
    /**
     * The full month in which this report is run. Could include dates in
     * the future.
     *
     * Generated from protobuf enum <code>THIS_MONTH = 4;</code>
     */
    const THIS_MONTH = 4;
    /**
     * From the beginning of the calendar month in which the report is run, to
     * up to and including the day the report is run.
     *
     * Generated from protobuf enum <code>THIS_MONTH_TO_DATE = 26;</code>
     */
    const THIS_MONTH_TO_DATE = 26;
    /**
     * The full quarter in which this report is run. Could include dates
     * in the future.
     *
     * Generated from protobuf enum <code>THIS_QUARTER = 5;</code>
     */
    const THIS_QUARTER = 5;
    /**
     * From the beginning of the calendar quarter in which the report is run,
     * up to and including the day the report is run.
     *
     * Generated from protobuf enum <code>THIS_QUARTER_TO_DATE = 27;</code>
     */
    const THIS_QUARTER_TO_DATE = 27;
    /**
     * The full year in which this report is run. Could include dates in
     * the future.
     *
     * Generated from protobuf enum <code>THIS_YEAR = 6;</code>
     */
    const THIS_YEAR = 6;
    /**
     * From the beginning of the calendar year in which the report is run, to
     * up to and including the day the report is run.
     *
     * Generated from protobuf enum <code>THIS_YEAR_TO_DATE = 28;</code>
     */
    const THIS_YEAR_TO_DATE = 28;
    /**
     * The entire previous calendar week, Monday to Sunday (inclusive),
     * preceding the calendar week the report is run.
     *
     * Generated from protobuf enum <code>LAST_WEEK = 7;</code>
     */
    const LAST_WEEK = 7;
    /**
     * The entire previous calendar month preceding the calendar month the
     * report is run.
     *
     * Generated from protobuf enum <code>LAST_MONTH = 8;</code>
     */
    const LAST_MONTH = 8;
    /**
     * The entire previous calendar quarter preceding the calendar quarter the
     * report is run.
     *
     * Generated from protobuf enum <code>LAST_QUARTER = 9;</code>
     */
    const LAST_QUARTER = 9;
    /**
     * The entire previous calendar year preceding the calendar year the
     * report is run.
     *
     * Generated from protobuf enum <code>LAST_YEAR = 10;</code>
     */
    const LAST_YEAR = 10;
    /**
     * The 7 days preceding the day the report is run.
     *
     * Generated from protobuf enum <code>LAST_7_DAYS = 11;</code>
     */
    const LAST_7_DAYS = 11;
    /**
     * The 30 days preceding the day the report is run.
     *
     * Generated from protobuf enum <code>LAST_30_DAYS = 12;</code>
     */
    const LAST_30_DAYS = 12;
    /**
     * The 60 days preceding the day the report is run.
     *
     * Generated from protobuf enum <code>LAST_60_DAYS = 13;</code>
     */
    const LAST_60_DAYS = 13;
    /**
     * The 90 days preceding the day the report is run.
     *
     * Generated from protobuf enum <code>LAST_90_DAYS = 14;</code>
     */
    const LAST_90_DAYS = 14;
    /**
     * The 180 days preceding the day the report is run.
     *
     * Generated from protobuf enum <code>LAST_180_DAYS = 15;</code>
     */
    const LAST_180_DAYS = 15;
    /**
     * The 360 days preceding the day the report is run.
     *
     * Generated from protobuf enum <code>LAST_360_DAYS = 16;</code>
     */
    const LAST_360_DAYS = 16;
    /**
     * The 365 days preceding the day the report is run.
     *
     * Generated from protobuf enum <code>LAST_365_DAYS = 17;</code>
     */
    const LAST_365_DAYS = 17;
    /**
     * The entire previous 3 calendar months preceding the calendar month the
     * report is run.
     *
     * Generated from protobuf enum <code>LAST_3_MONTHS = 18;</code>
     */
    const LAST_3_MONTHS = 18;
    /**
     * The entire previous 6 calendar months preceding the calendar month the
     * report is run.
     *
     * Generated from protobuf enum <code>LAST_6_MONTHS = 19;</code>
     */
    const LAST_6_MONTHS = 19;
    /**
     * The entire previous 6 calendar months preceding the calendar month the
     * report is run.
     *
     * Generated from protobuf enum <code>LAST_12_MONTHS = 20;</code>
     */
    const LAST_12_MONTHS = 20;
    /**
     * From 3 years before the report is run, to the day before the report is
     * run, inclusive.
     *
     * Generated from protobuf enum <code>ALL_AVAILABLE = 21;</code>
     */
    const ALL_AVAILABLE = 21;
    /**
     * Only valid when used in the comparison_date_range field. The complete
     * period preceding the date period provided in date_range.
     * In the case where date_range is a FixedDateRange of N days, this will
     * be a period of N days where the end date is the date preceding the
     * start date of the date_range.
     * In the case where date_range is a RelativeDateRange, this will be a
     * period of the same time frame preceding the date_range. In the case
     * where the date_range does not capture the full period because a report
     * is run in the middle of that period, this will still be the full
     * preceding period. For example, if date_range is THIS_WEEK, but the
     * report is run on a Wednesday, THIS_WEEK will be Monday - Wednesday, but
     * PREVIOUS_PERIOD will be Monday - Sunday.
     *
     * Generated from protobuf enum <code>PREVIOUS_PERIOD = 22;</code>
     */
    const PREVIOUS_PERIOD = 22;
    /**
     * Only valid when used in the comparison_date_range field. The period
     * starting 1 year prior to the date period provided in date_range.
     * In the case where date_range is a FixedDateRange, this will be a date
     * range starting 1 year prior to the date_range start date and ending 1
     * year prior to the date_range end date.
     * In the case where date_range is a RelativeDateRange, this will be a
     * period of the same time frame exactly 1 year prior to the date_range.
     * In the case where the date_range does not capture the full period
     * because a report is run in the middle of that period, this will still
     * be the full period 1 year prior. For example, if date range is
     * THIS_WEEK, but the report is run on a Wednesday, THIS_WEEK will be
     * Monday - Wednesday, but SAME_PERIOD_PREVIOUS_YEAR will be Monday -
     * Sunday.
     *
     * Generated from protobuf enum <code>SAME_PERIOD_PREVIOUS_YEAR = 24;</code>
     */
    const SAME_PERIOD_PREVIOUS_YEAR = 24;

    private static $valueToName = [
        self::RELATIVE_DATE_RANGE_UNSPECIFIED => 'RELATIVE_DATE_RANGE_UNSPECIFIED',
        self::TODAY => 'TODAY',
        self::YESTERDAY => 'YESTERDAY',
        self::THIS_WEEK => 'THIS_WEEK',
        self::THIS_WEEK_TO_DATE => 'THIS_WEEK_TO_DATE',
        self::THIS_MONTH => 'THIS_MONTH',
        self::THIS_MONTH_TO_DATE => 'THIS_MONTH_TO_DATE',
        self::THIS_QUARTER => 'THIS_QUARTER',
        self::THIS_QUARTER_TO_DATE => 'THIS_QUARTER_TO_DATE',
        self::THIS_YEAR => 'THIS_YEAR',
        self::THIS_YEAR_TO_DATE => 'THIS_YEAR_TO_DATE',
        self::LAST_WEEK => 'LAST_WEEK',
        self::LAST_MONTH => 'LAST_MONTH',
        self::LAST_QUARTER => 'LAST_QUARTER',
        self::LAST_YEAR => 'LAST_YEAR',
        self::LAST_7_DAYS => 'LAST_7_DAYS',
        self::LAST_30_DAYS => 'LAST_30_DAYS',
        self::LAST_60_DAYS => 'LAST_60_DAYS',
        self::LAST_90_DAYS => 'LAST_90_DAYS',
        self::LAST_180_DAYS => 'LAST_180_DAYS',
        self::LAST_360_DAYS => 'LAST_360_DAYS',
        self::LAST_365_DAYS => 'LAST_365_DAYS',
        self::LAST_3_MONTHS => 'LAST_3_MONTHS',
        self::LAST_6_MONTHS => 'LAST_6_MONTHS',
        self::LAST_12_MONTHS => 'LAST_12_MONTHS',
        self::ALL_AVAILABLE => 'ALL_AVAILABLE',
        self::PREVIOUS_PERIOD => 'PREVIOUS_PERIOD',
        self::SAME_PERIOD_PREVIOUS_YEAR => 'SAME_PERIOD_PREVIOUS_YEAR',
    ];

    public static function name($value)
    {
        if (!isset(self::$valueToName[$value])) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no name defined for value %s', __CLASS__, $value));
        }
        return self::$valueToName[$value];
    }


    public static function value($name)
    {
        $const = __CLASS__ . '::' . strtoupper($name);
        if (!defined($const)) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no value defined for name %s', __CLASS__, $name));
        }
        return constant($const);
    }
}


