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

namespace bisual\JWTAuth\Contracts\Providers;

interface Storage
{
    /**
     * @param string $key
     * @param mixed  $value
     * @param int    $minutes
     *
     * @return void
     */
    public function add($key, $value, $minutes);

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function forever($key, $value);

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function destroy($key);

    /**
     * @return void
     */
    public function flush();
}
