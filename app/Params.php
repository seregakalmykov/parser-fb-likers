<?php

namespace liw\app;


class Params
{
    public static $ajaxParams = [
        "link" => "https://www.facebook.com/ajax/pagelet/generic.php/BrowseScrollingSetPagelet?data=",
        "query" => [
            "view" => "list",
            "encoded_query" => "{\"bqf\":\"likers(524285880946743)\"}",
            "encoded_title" => "WyJQZW9wbGUrd2hvK2xpa2UrIix7InRleHQiOiJQcm9tb1JlcHVibGljIiwidWlkIjo1MjQyODU4ODA5NDY3NDMsInR5cGUiOiJwYWdlIn1d",
            "ref" => "unknown",
            "logger_source" => "www_main",
            "typeahead_sid" => "",
            "tl_log" => false,
            "experience_type" => "grammar",
            "ref_path" => "",
            "is_trending" => false,
            "cursor" => "",
            "page_number" => 2,
        ],
        "link_add" => '&__user=',
    ],
    $fbLogin = [
        "email" => '',
        "pass" => '',
    ];
}
