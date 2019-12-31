<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Notification\NotificationResource;
use App\Models\Notification;
use App\User;
use Illuminate\Support\Facades\DB;

class NotificationController extends BaseController
{

    public function index()
    {
        $userId = $this->guard()->user()->id;
        //$userId = 1;
        $items = Notification::where([
                'notifiable_type' => User::class,
                'notifiable_id' => $userId,
            ])->join('notification_actions', 'notifications.data->action', '=', 'notification_actions.name')
            ->join('notification_user', function ($join) use ($userId) {
                $join->on('notification_actions.id', '=', 'notification_user.action_id')
                    ->where('notification_user.user_id', '=', $userId);
            })
            ->where('notification_user.push', 1)
            ->select(DB::raw('notifications.*, notification_actions.title, notification_actions.id as action_id'))
            ->get();

        return NotificationResource::collection($items);

    }

}
