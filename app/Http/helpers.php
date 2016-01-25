<?php
/**
 * Loads asset over https or http depending on the environment (production or development respectively)
 * @param  string $asset_url url link
 * @return string
 */
function load_asset($asset_url)
{
    return ( env('APP_ENV') === 'production' ) ? secure_asset($asset_url) : asset($asset_url);
}

function domain_name()
{
    return Request::root();
}
