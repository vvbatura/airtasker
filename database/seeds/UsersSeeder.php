<?php

use App\Constants\UserConstants;
use App\Models\NotificationAction;
use App\Models\Profile;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    const TABLE = 'users';
    const TABLE_PROFILE = 'profiles';

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

        $this->actions = NotificationAction::get();

        $this->createUsers(UserConstants::ROLE_ADMIN, 1, [
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@airtasker.com',
        ]);
        $this->createUsers(UserConstants::ROLE_MODERATOR,3);
        $this->createUsers(UserConstants::ROLE_CLIENT,30);

        $this->command->info('Created ' . self::TABLE . ' with profile.');

    }

    protected $actions;

    protected function createUsers($role, $number =1, $data =[])
    {
        $users = factory(User::class, $number)->create($data);

        foreach ($users as $user) {
            $user->assignRole($role);
            $user->_profile()->save(factory(Profile::class)->make());
            foreach ($this->actions as $action) {
                $user->_actions()->attach($action->getId(), [
                    'email' => 1, 'sms' => 1, 'push' => 1,
                ]);
            }
        }
    }
}
