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

namespace bisual\JWTAuth\Claims;

use DateInterval;
use DateTimeInterface;
use bisual\JWTAuth\Exceptions\InvalidClaimException;
use bisual\JWTAuth\Support\Utils;

trait DatetimeTrait
{
    /**
     * Time leeway in seconds.
     *
     * @var int
     */
    protected $leeway = 0;

    /**
     * Set the claim value, and call a validate method.
     *
     * @param mixed $value
     *
     * @throws InvalidClaimException
     *
     * @return $this
     */
    public function setValue($value)
    {
        if ($value instanceof DateInterval) {
            $value = Utils::now()->add($value);
        }

        if ($value instanceof DateTimeInterface) {
            $value = $value->getTimestamp();
        }

        return parent::setValue($value);
    }

    /**
     * {@inheritdoc}
     */
    public function validateCreate($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidClaimException($this);
        }

        return $value;
    }

    /**
     * Determine whether the value is in the future.
     *
     * @param mixed $value
     *
     * @return bool
     */
    protected function isFuture($value)
    {
        return Utils::isFuture($value, $this->leeway);
    }

    /**
     * Determine whether the value is in the past.
     *
     * @param mixed $value
     *
     * @return bool
     */
    protected function isPast($value)
    {
        return Utils::isPast($value, $this->leeway);
    }

    /**
     * Set the leeway in seconds.
     *
     * @param int $leeway
     *
     * @return $this
     */
    public function setLeeway($leeway)
    {
        $this->leeway = $leeway;

        return $this;
    }
}
