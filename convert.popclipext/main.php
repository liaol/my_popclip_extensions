<?php
$text=trim(getenv('POPCLIP_TEXT'));

$preg_list = array(
    '/^\d{10}$/' => '_timestamp2str',
    '/^(\\\u([0-9a-fA-F]{4}))*$/' => '_unicode2utf8',
    '/^.*%[0-9a-z]{2}.*$/' => '_urldecode',
   // '/^.*==$/' => '_base64',
);

foreach ($preg_list as $pattern => $function) {
    if (preg_match($pattern, $text) > 0) {
        $data = call_user_func_array($function, array($text));
        echo $data;
        break;
    }
}

function _unicode2utf8($s)
{
    return json_decode('"' . $s . '"');
}

function _base64($s)
{
    return base64_decode($s);
}

function _timestamp2str($s)
{
    date_default_timezone_set('Asia/Shanghai');
    return date('Y-m-d H:i:s', $s);
}

function _urldecode($s)
{
    return urldecode($s);
}
