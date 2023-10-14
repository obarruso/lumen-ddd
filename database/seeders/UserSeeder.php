<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Bitres\User\Application\UseCases\Commands\StoreUserCommand;
use App\Bitres\User\Domain\Factories\UserFactory;
use App\Bitres\User\Domain\Model\ValueObjects\Password;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new StoreUserCommand(UserFactory::new([
            'uuid' => Str::uuid(),
            'username' => 'admin',
            'email' => 'admin@bitres.com',
            'is_admin' => true,
        ]), new Password('adminpolr', 'adminpolr')))->execute();
        for( $i = 100; $i <= 320; $i++ ) {
            $name = 'prueba' . $i;
            (new StoreUserCommand(UserFactory::new([
                'username' => $name,
            ]), new Password($name, $name)))->execute();
        }

    }
}
