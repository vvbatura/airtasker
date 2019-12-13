<?php

use App\ConfigProject\Constants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        Role::create([ 'name' => Constants::ROLE_ADMIN ]);
        Role::create([ 'name' => Constants::ROLE_MODERATOR ]);
        Role::create([ 'name' => Constants::ROLE_CLIENT ]);
    }
}
