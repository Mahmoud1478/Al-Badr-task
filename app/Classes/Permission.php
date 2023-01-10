<?php

namespace App\Classes;

class Permission
{
    private static array $available = [
        'update-clients'=>[
            'name' => 'Update Clients'
        ],
        'delete-clients'=>[
            'name' => 'Delete Clients'
        ],
        'activate-clients'=>[
            'name' => 'Activate Clients'
        ],
        'create-clients'=> [
            'name' => 'Create Clients'
        ],
    ];

    /**
     * @param string $permission
     * @return bool
     */
    static function check(string $permission): bool
    {
        return isset(static::$available[$permission]);
    }

    /**
     * @return array|string[][]
     */
    public static function all(): array
    {
        return  static::$available;
    }
    /**
     * @return array|string[]
     */
    public static function keys(): array
    {
        return array_keys(static::$available);
    }





}
