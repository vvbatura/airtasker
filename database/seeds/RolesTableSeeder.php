<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    const TABLE = 'roles';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(self::TABLE)->delete();
        DB::statement('ALTER TABLE ' . self::TABLE . ' AUTO_INCREMENT = 1');

        Role::create([ 'name' => User::ROLE_ADMIN ]);
        Role::create([ 'name' => User::ROLE_MODERATOR ]);
        Role::create([ 'name' => User::ROLE_CLIENT ]);
    }
}
