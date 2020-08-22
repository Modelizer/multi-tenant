<?php


/**
 * @param $routeName
 * @param mixed ...$params
 * @return string
 */
function partner_route($routeName, ...$params)
{
    $params['partner'] = config('multi-tenant.partner');

    return route($routeName, $params);
}

/**
 * @return string
 */
function domain()
{
    return parse_url(env('APP_URL'))['host'];
}

/**
 * @return string|null
 */
function sub_domain()
{
    if (app()->runningInConsole()) {
        return null;
    }

    $subDomain = explode('.', parse_url(url()->current())['host'])[0];

    return in_array($subDomain, get_reserve_domains()) ? null : $subDomain;
}

/**
 * @return string
 */
function fqdn()
{
    return sub_domain().'.'.domain();
}

/**
 * @return array
 */
function get_reserve_domains()
{
    return [
        config('multi-tenant.reserve-domains'),
    ];
}
