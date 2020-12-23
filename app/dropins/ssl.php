<?php
/*
  DropIn Name: Enable and Force SSL
  Description: A dropin which loads the entire eduTrac SIS installation over HTTPS.
 */

$app = \Liten\Liten::getInstance();

function enable_force_url_ssl()
{
    $app = \Liten\Liten::getInstance();
    $domain = str_replace('http://', '', url('/'));
    $url = 'https://' . $domain;

    if ($app->req->server['SERVER_PORT'] != 443) {
        $https = rtrim($url, '/');
        redirect($https . $app->req->server['REQUEST_URI']);
        exit();
    }
    return $url;
}
$app->hook->add_filter('base_url', 'enable_force_url_ssl');