<?php
declare(strict_types=1);
namespace server\enum;

abstract class Activity {
    const KEYS = [
        "CREATE" => [
            "name" => "Create",
            "verb" => "Creating",
            "predicate" => "Added",
            "value" => 1,
            "key" => "create",
        ],
        "READ" => [
            "name" => "Read",
            "verb" => "Reading",
            "predicate" => "Read",
            "value" => 2,
            "key" => "read",
        ],
        "UPDATE" => [
            "name" => "Update",
            "verb" => "Updating",
            "predicate" => "Modified",
            "value" => 3,
            "key" => "update"
        ],
        "DELETE" => [
            "name" => "Delete",
            "verb" => "Deleting",
            "predicate" => "Deleted",
            "value" => 4,
            "key" => "delete"
        ],
        "LOGIN" => [
            "name" => "Login",
            "verb" => "Logging in",
            "predicate" => "Logged in",
            "value" => 5,
            "key" => "login"
        ],
        "LOGIN_COOKIE" => [
            "name" => "Login & Stay",
            "verb" => "Logging in",
            "predicate" => "Logged in & checked 'keep logged'",
            "value" => 5,
            "key" => "login_cookie"
        ],
        "LOGOUT" => [
            "name" => "Log out",
            "verb" => "Logging out",
            "predicate" => "Logged out",
            "value" => 6,
            "key" => "logout",
        ],
        "PAY" => [
            "name" => "Pay",
            "verb" => "Paying",
            "predicate" => "Paid",
            "value" => 7,
            "key" => "pay",
        ],
        "MESSAGE" => [
            "name" => "Message",
            "verb" => "Messaging",
            "predicate" => "Messaged",
            "value" => 8,
            "key" => "message",
        ],
        "ARCHIVE" => [
            "name" => "Archive",
            "verb" => "Archiving",
            "predicate" => "Archived",
            "value" => 9,
            "key" => "archive",
        ],
        "SEND" => [
            "name" => "Send",
            "verb" => "Sending",
            "predicate" => "Sent",
            "value" => 10,
            "key" => "send",
        ],
        "UPLOAD" => [
            "name" => "Upload",
            "verb" => "uploading",
            "predicate" => "uploaded",
            "value" => 11,
            "key" => "upload",
        ],
        "RESTORE" => [
            "name" => "Restore",
            "verb" => "Restoring",
            "predicate" => "Restored",
            "value" => 12,
            "key" => "restore",
        ],
        "ASSIGN" => [
            "name" => "Assign",
            "verb" => "Assigning",
            "predicate" => "Assigned",
            "value" => 13,
            "key" => "assign",
        ],
        "COMMENT" => [
            "name" => "Comment",
            "verb" => "Commenting",
            "predicate" => "Commented",
            "value" => 14,
            "key" => "comment",
        ],
        "CORRECT" => [
            "name" => "Correct",
            "verb" => "Correcting",
            "predicate" => "Corrected",
            "value" => 15,
            "key" => "correct",
        ],
        "REJECT" => [
            "name" => "Reject",
            "verb" => "Rejecting",
            "predicate" => "Rejected",
            "value" => 16,
            "key" => "reject",
        ],
        "APPROVE" => [
            "name" => "Approve",
            "verb" => "Approving",
            "predicate" => "Approved",
            "value" => 17,
            "key" => "approve",
        ],
        "RESERVE" => [
            "name" => "Reserve",
            "verb" => "Reserving",
            "predicate" => "Reserved",
            "value" => 18,
            "key" => "reserve",
        ],
        "ORDER" => [
            "name" => "Order",
            "verb" => "Ordering",
            "predicate" => "Ordered",
            "value" => 19,
            "key" => "order",
        ],
        "PLACE" => [
            "name" => "Place",
            "verb" => "Placing",
            "predicate" => "Posted",
            "value" => 20,
            "key" => "place",
        ],
    ];

    public static function get($key): object {
        $rtn = [];
        foreach (Activity::KEYS as $v) {
            if ($v['value'] == $key or $v['key'] == $key)
                $rtn = $v;
        }
        return (object) $rtn;
    }
}