<?php declare(strict_types = 1);

namespace Tests;

use App\Validation\SiteValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class SiteValidatorTest
 * @package Tests
 */
class SiteValidatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testIsValid() : void
    {
        self::assertFalse((new SiteValidator('htpp://example.com'))->isValid());
        self::assertFalse((new SiteValidator('https://example,com'))->isValid());
        self::assertFalse((new SiteValidator('https:/example.com'))->isValid());
        self::assertFalse((new SiteValidator('https:/example'))->isValid());
        self::assertTrue((new SiteValidator('https://example.com.ua'))->isValid());
        self::assertTrue((new SiteValidator('https://sub.example.com'))->isValid());
    }
}
