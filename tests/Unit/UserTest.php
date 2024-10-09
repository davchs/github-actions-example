<?php

namespace App\Tests\Unit;

use App\Entity\User;
use App\Tests\Support\UnitTester;
use Codeception\Test\Unit;

class UserTest extends Unit
{
    protected UnitTester $tester;

    public function testTogglePremiumStatusIsTrue(): void
    {
        // Arrange
        $user = new User();

        // Act
        $user->togglePremiumStatus();

        // Assert
        $this->assertTrue($user->isPremium());
    }

    public function testDefaultPremiumStatusIsTrue(): void
    {
        // Arrange
        $user = new User();

        // Assert
        $this->assertFalse($user->isPremium());
    }
}
