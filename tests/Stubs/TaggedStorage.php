<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) 2014-2021 Sean Tymon <tymon148@gmail.com>
 * (c) 2021 PHP Open Source Saver
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace bisual\JWTAuth\Test\Stubs;

use bisual\JWTAuth\Providers\Storage\Illuminate as Storage;

class TaggedStorage extends Storage
{
    // It's extremely challenging to test the actual functionality of the provider's
    // cache() function, because it relies on calling method_exists on methods that
    // aren't defined in the interface. Getting those conditionals to behave as expected
    // would be a lot of finicky work compared to verifying their functionality by hand.
    // So instead we'll just set this value manually...
    protected $supportsTags = true;
}
