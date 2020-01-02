<?php

use App\Constants\UserConstants;
use App\Models\NotificationAction;
use App\Models\UserProfile;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    const TABLE = 'users';
    const TABLE_PROFILE = 'user_profiles';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(self::TABLE)->delete();
        DB::statement('ALTER TABLE ' . self::TABLE . ' AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE ' . self::TABLE_PROFILE . ' AUTO_INCREMENT = 1');

        $this->actionIds = NotificationAction::get()->pluck('id')->toArray();

        $this->createUsers(UserConstants::ROLE_ADMIN, 1, [
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@airtasker.com',
        ]);
        $this->createUsers(UserConstants::ROLE_MODERATOR,3);
        $this->createUsers(UserConstants::ROLE_CLIENT,30);

        $this->command->info('Created ' . self::TABLE . ' with profile.');

    }

    protected $actionIds;

    protected function createUsers($role, $number =1, $data =[])
    {
        $users = factory(User::class, $number)->create($data);

        foreach ($users as $user) {
            $user->assignRole($role);
            $user->_profile()->save(factory(UserProfile::class)->make());
            $user->_actions()->attach($this->actionIds);
        }
    }
}
