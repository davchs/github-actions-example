<?php

namespace App\Tests\Acceptance;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Symfony\Component\Uid\Uuid;

class TogglePremiumCest
{
    private string $userId;

    /**
     * @dataProvider premiumStatusProvider
     */
    public function userCanTogglePremiumStatus(AcceptanceTester $I, Example $example): void
    {
        // Arrange
        $this->createUser($I, !$example['finalIsPremium']);
        $I->amOnPage("/user/{$this->userId}");
        $I->see("Current Status: {$example['initialStatus']}");
        $I->wait(2);

        // Act
        $I->click('Toggle Premium Status');

        // Assert
        $I->see("Current Status: {$example['finalStatus']}");
        $I->seeInDatabase('users', [
            'id' => $this->userId,
            'is_premium' => $example['finalIsPremium'],
        ]);
        $I->wait(2);
    }

    private function createUser(AcceptanceTester $I, bool $isPremium): void
    {
        $this->userId = Uuid::v4()->toString();
        $I->haveInDatabase('users', [
            'id' => $this->userId,
            'email' => 'test@example.com',
            'is_premium' => $isPremium,
        ]);
    }

    protected function premiumStatusProvider(): array
    {
        return [
            ['initialStatus' => 'Standard', 'finalStatus' => 'Premium', 'finalIsPremium' => true],
            ['initialStatus' => 'Premium', 'finalStatus' => 'Standard', 'finalIsPremium' => false],
        ];
    }
}
