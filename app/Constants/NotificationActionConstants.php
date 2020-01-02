<?php

namespace App\Constants;

class NotificationActionConstants
{

    const ACTION_REGISTRATION_NAME = 'registration';
    const ACTION_VERIFICATION_NAME = 'verification';
    const ACTION_FORGOT_PASSWORD_NAME = 'forgot-password';
    const ACTION_RESET_PASSWORD_NAME = 'reset-password';
    const ACTION_LOGIN_NAME = 'login';
    const ACTION_LOGIN_EN = 'Login';
    const ACTION_LOGIN_DE = 'Einloggen';
    const ACTION_LOGIN = [
        SystemConstants::LANGUAGE_EN => self::ACTION_LOGIN_EN, SystemConstants::LANGUAGE_DE => self::ACTION_LOGIN_DE
    ];
    const ACTION_LOGOUT_NAME = 'logout';
    const ACTION_LOGOUT_EN = 'Logout';
    const ACTION_LOGOUT_DE = 'Ausloggen';
    const ACTION_LOGOUT = [
        SystemConstants::LANGUAGE_EN => self::ACTION_LOGOUT_EN, SystemConstants::LANGUAGE_DE => self::ACTION_LOGOUT_DE
    ];
    const ACTION_CREATED_TASK_NAME = 'created-task';
    const ACTION_CREATED_TASK__EN = 'Created Task';
    const ACTION_CREATED_TASK__DE = 'Erstellte Aufgabe';
    const ACTION_CREATED_TASK = [
        SystemConstants::LANGUAGE_EN => self::ACTION_CREATED_TASK__EN, SystemConstants::LANGUAGE_DE => self::ACTION_CREATED_TASK__DE
    ];
    const ACTION_UPDATED_TASK_NAME = 'updated-task';
    const ACTION_UPDATED_TASK__EN = 'Updated Task';
    const ACTION_UPDATED_TASK__DE = 'Aktualisierte Aufgabe';
    const ACTION_UPDATED_TASK = [
        SystemConstants::LANGUAGE_EN => self::ACTION_UPDATED_TASK__EN, SystemConstants::LANGUAGE_DE => self::ACTION_UPDATED_TASK__DE
    ];
}
