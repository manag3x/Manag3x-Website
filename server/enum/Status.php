<?php
/**
 * DO NOT MANIPULATE THE ORDER OF ARRANGEMENT
 * THIS FILE IS VERY CRUCIAL TO THE ENTIRE SYSTEM
 * DEVELOPER: github => mrprotocoll
 */
declare(strict_types=1);
namespace server\enum;

abstract class Status {
    const KEYS = [
        0 => ["Pending","primary"],
        1 => ["Active","success"],
        2 => ["In-Active","danger"],
        3 => ["Assigned", "primary"],
        4 => ["Completed","success"],
        5 => ["Rejected","danger"],
        6 => ["Rejected By Editor","danger"],
        7 => ["New","info"],
        8 => ["Awaiting Client Approval","success"],
        9 => ["Approved","success"],
        10 => ["Corrected by Client","secondary"],
        11 => ["Posted","success"],
        12 => ["Awaiting Editor Approval","secondary"],
        13 => ["Needs Improvement","warning"],
    ];

    public static function get($key): object {
        $rtn = [];
        foreach (Status::KEYS as $k => $v) {
            if ($k == $key or $v == $key)
                $rtn['value'] = $v;
        }
        return (object) $rtn;
    }
}