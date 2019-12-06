<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    const TABLE = 'users';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(self::TABLE)->delete();
        DB::statement('ALTER TABLE ' . self::TABLE . ' AUTO_INCREMENT = 1');

        $this->createUsers(\App\User::ROLE_ADMIN, 1, [
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@airtasker.com',
        ]);
        $this->createUsers(\App\User::ROLE_MODERATOR,3);
        $this->createUsers(\App\User::ROLE_CLIENT,30);

        $this->command->info('Created ' . self::TABLE . ' with profile.');

    }

    protected function createUsers($role, $number =1, $data =[])
    {
        $users = factory(\App\User::class, $number)->create($data);

        foreach ($users as $user) {
            $user->assignRole($role);
            $user->_profile()->save(factory(\App\Models\Profile::class)->make());
        }
    }
}
