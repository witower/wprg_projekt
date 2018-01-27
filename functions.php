<?php

/**
 * My first autoloader
 * @param $class_name
 */
function __autoload($class_name)
{
    include $class_name.'.php';
}


/**
 * Starts session with $relativepath
 * @param string $relativepath
 */
function path_aware_session_start($relativepath = '/~s16125/WPR/projekt/')
{
    $currentCookieParams = session_get_cookie_params();
    session_set_cookie_params(
        $currentCookieParams["lifetime"],
        $relativepath,
        $currentCookieParams["domain"],
        $currentCookieParams["secure"],
        $currentCookieParams["httponly"]
    );
    session_start();
}


/** Attempt to obtain the visitor’s actual IP-Address (as best as possible).
 * @return mixed
 */
function get_real_IP() {
    $headers = array(
        "HTTP_VIA",
        "HTTP_X_FORWARDED_FOR",
        "HTTP_FORWARDED_FOR",
        "HTTP_X_FORWARDED",
        "HTTP_FORWARDED",
        "HTTP_CLIENT_IP",
        "HTTP_HTTP_CLIENT_IP",
        "HTTP_FORWARDED_FOR_IP",
        "VIA",
        "X_FORWARDED_FOR",
        "FORWARDED_FOR",
        "X_FORWARDED",
        "FORWARDED",
        "CLIENT_IP",
        "FORWARDED_FOR_IP",
        "HTTP_XPROXY_CONNECTION",
        "HTTP_PROXY_CONNECTION",
        "HTTP_X_REAL_IP",
        "HTTP_X_PROXY_ID",
        "HTTP_USERAGENT_VIA",
        "HTTP_HTTP_PC_REMOTE_ADDR",
        "HTTP_X_CLUSTER_CLIENT_IP"
    );

    foreach ($headers as $header)
        if (isset($_SERVER[$header]) && !empty($_SERVER[$header]))
            return $_SERVER[$header];

    if (trim($_SERVER["SERVER_ADDR"])==trim($_SERVER["REMOTE_ADDR"]))
        return $_SERVER["SERVER_ADDR"];

    return $_SERVER["REMOTE_ADDR"];
}

function unknown_ip($cip){
    if (
        (!$cip) ||
        ($cip=='::1')
    ) $cip='';
    return $cip;
}