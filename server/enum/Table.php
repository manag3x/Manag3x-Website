<?php
/**
 * DO NOT MANIPULATE THE ORDER OF ARRANGEMENT
 * THIS FILE IS VERY CRUCIAL TO THE ENTIRE SYSTEM
 * DEVELOPER: github => mrprotocoll
 */
declare(strict_types=1);
namespace server\enum;

abstract class Tables {
    const KEYS = [
        "customer"     => "customers",
        "inventory"    => "inventory",
        "publisher"    => "publishers",
        "writer"       => "writers",
        "admin"        => "system_user",
        "editor"       => "editors",
        "guest"        => "guest_writers",
        "purl"         => "order_promoted_url",
        "content"      => "order_content",
        "word"         => "word_count",
        "topic"        => "topics",
        "order"        => "orders",
        "projectCat"   => "project_categories",
        "event_log"    => "system_user_event_log",
        "genLog"       => "general_log",
        "loginLog"     => "login_log",
        "custDoc"      => "client_docs",
        "country"      => "countries",
        "cat"          => "category",
        "web_limit"    => "website_limitations",
        "webCat"       => "website_categories",
        "constraint"   => "website_constraints",
        "currency"     => "currency",
        "cInventory"   => "client_inventory",
        "pInventory"   => "publisher_inventory",
        "correction"   => "content_corrections",
        "rejection"    => "content_rejections",
        "comment"      => "task_comments",
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