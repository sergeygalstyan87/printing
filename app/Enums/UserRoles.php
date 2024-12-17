<?php

namespace App\Enums;

abstract class UserRoles{
    CONST SUPER_ADMIN = 1;
    CONST USER = 2;
    CONST MANAGER = 3;
    CONST DESIGNER = 4;
    CONST FRONTDESK = 5;

    public static function getRoleName($roleId)
    {
        $roles = [
            self::SUPER_ADMIN => 'Admin',
            self::USER => 'User',
            self::MANAGER => 'Manager',
            self::DESIGNER => 'Designer',
            self::FRONTDESK => 'FrontDesk',
        ];

        return $roles[$roleId] ?? 'Unknown';
    }

}