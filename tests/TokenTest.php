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

namespace bisual\JWTAuth\Test;

use bisual\JWTAuth\Token;

class TokenTest extends AbstractTestCase
{
    /**
     * @var Token
     */
    protected $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->token = new Token('foo.bar.baz');
    }

    /** @test */
    public function itShouldReturnTheTokenWhenCastingToAString()
    {
        $this->assertEquals((string) $this->token, $this->token);
    }

    /** @test */
    public function itShouldReturnTheTokenWhenCallingGetMethod()
    {
        $this->assertIsString($this->token->get());
    }
}
