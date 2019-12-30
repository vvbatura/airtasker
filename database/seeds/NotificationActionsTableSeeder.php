<?php

use App\Constants\NotificationActionConstants;
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

        Role::create([ 'title' => NotificationActionConstants::ACTION_LOGIN ]);
        Role::create([ 'title' => NotificationActionConstants::ACTION_LOGOUT ]);
    }
}
