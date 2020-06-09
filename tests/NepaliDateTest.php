<?php
use PHPUnit\Framework\TestCase;

final class NepaliDateTest extends TestCase
{
    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'user@example.com',
            'user@example.com'
        );
    }
}
