<?php

use App\Constants\NotificationActionConstants;
use App\Models\NotificationAction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class NotificationActionsTableSeeder extends Seeder
{
    const TABLE = 'notification_actions';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(self::TABLE)->delete();
        DB::statement('ALTER TABLE ' . self::TABLE . ' AUTO_INCREMENT = 1');

        NotificationAction::create([ 'name' => NotificationActionConstants::ACTION_LOGIN_NAME, 'title' => NotificationActionConstants::ACTION_LOGIN ]);
        NotificationAction::create([ 'name' => NotificationActionConstants::ACTION_LOGOUT_NAME, 'title' => NotificationActionConstants::ACTION_LOGOUT ]);
        NotificationAction::create([ 'name' => NotificationActionConstants::ACTION_CREATED_TASK_NAME, 'title' => NotificationActionConstants::ACTION_CREATED_TASK ]);
        NotificationAction::create([ 'name' => NotificationActionConstants::ACTION_UPDATED_TASK_NAME, 'title' => NotificationActionConstants::ACTION_UPDATED_TASK ]);
    }
}
