<?php

namespace Framework\Tests;

namespace Zest\Tests\Hashing;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use Zest\Hashing\BcryptHashing;
use Zest\Hashing\ArgonHashing;

class HasherTest extends TestCase
{
    public function testBasicBcryptHashing()
    {
        $hashing = new BcryptHashing(['cost' => 10]);
        $value = $hashing->make('password');
        $this->assertNotSame('password', $value);
        $this->assertTrue($hashing->verify('password', $value));
        $this->assertFalse($hashing->needsRehash($value));
        $this->assertTrue($hashing->needsRehash($value, ['cost' => 1]));
        $this->assertSame('bcrypt', password_get_info($value)['algoName']);
    }
    public function testBasicArgon2iHashing()
    {
        if (! defined('PASSWORD_ARGON2I')) {
            $this->markTestSkipped('PHP not compiled with Argon2i hashing support.');
        }
        $hashing = new ArgonHashing(['memory' => 512, 'time' => 5, 'threads' => 3]);
        $value = $hashing->make('password');
        $this->assertNotSame('password', $value);
        $this->assertTrue($hashing->verify('password', $value));
        $this->assertTrue($hashing->needsRehash($value, ['memory' => 512, 'time' => 5, 'threads' => 3]));
        $this->assertSame('argon2i', password_get_info($value)['algoName']);
    }

    public function testBasicBcryptVerification()
    {
        $this->expectException(RuntimeException::class);

        $hashing = new BcryptHashing(['cost' => 10,'verify' => true]);
        $value = $hashing->make('password');
		$hashing->verify($value);
    }
    public function testBasicArgon2iVerification()
    {
        $this->expectException(RuntimeException::class);
		$hashing = new ArgonHashing(['memory' => 512, 'time' => 5, 'threads' => 3, 'verofy' => true]);
        $value = $hashing->make('password');
		$hashing->verify($value);
    }

}
