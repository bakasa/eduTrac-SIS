<?php
/*
  DropIn Name: Enable SSL
  Description: A dropin which tranfers all HTTP requests over SSL.
 */

$app = \Liten\Liten::getInstance();

function enable_url_ssl()
{
    $domain = str_replace('http://', '', url('/'));
    $url = 'https://' . $domain;
    return $url;
}
$app->hook->add_filter('base_url', 'enable_url_ssl');