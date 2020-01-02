<?php

namespace App\Traits;

use App\Constants\NotificationActionConstants;
use App\Models\NotificationAction;

trait NotificationTrait
{

    public function buildActions($actionName)
    {
        $actions = ['database'];
        if ($actionId =NotificationAction::where('name', $actionName)->first()) {
            if ($action =$this->user->_actions->find($actionId)) {
                if ($action->pivot->email) { array_push($actions, 'mail'); }
                if ($action->pivot->sms) { array_push($actions, 'nexmo'); }

                return $actions;
            }
        }
        return ['database', 'mail', 'nexmo'];
    }

}
