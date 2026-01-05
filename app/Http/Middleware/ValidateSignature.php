<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

class ValidateSignature extends Middleware
{
    /**
     * The names of the query string parameters that should be ignored.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'fbclid',
        // 'gclid',
        // 'mc_eid',
        // 'mc_cid',
        // 'fb_action_ids',
        // 'fb_action_types',
        // 'fb_source',
        // 'ml_subscriber',
        // 'ml_subscriber_token',
    ];
}

