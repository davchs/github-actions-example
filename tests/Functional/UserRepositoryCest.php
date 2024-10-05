<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\Support\FunctionalTester;
use Symfony\Component\Uid\Uuid;

class UserRepositoryCest
{
    public function testFindUser(FunctionalTester $I): void
    {
        // Arrange
        $id = Uuid::v4();
        $I->haveInRepository(User::class, [
            'id' => (string) $id,
            'email' => 'test@example.com',
            'isPremium' => false,
        ]);
        $userRepository = $I->grabService(UserRepository::class);

        // Act
        $user = $userRepository->find($id);

        // Assert
        $I->assertNotNull($user);
        $I->assertEquals('test@example.com', $user->getEmail());
        $I->assertFalse($user->isPremium());
    }

    public function testSaveUser(FunctionalTester $I): void
    {
        // Arrange
        $userRepository = $I->grabService(UserRepository::class);
        $user = new User();
        $user->setEmail('test@sprad.io');
        $user->setIsPremium(true);

        // Act
        $userRepository->save($user, true);

        // Assert
        $I->seeInRepository(User::class, [
            'email' => 'test@sprad.io',
            'isPremium' => true,
        ]);
    }
}
