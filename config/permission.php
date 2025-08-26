<?php

return [

    'models' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `Spatie\Permission\Contracts\Permission` contract.
         */
        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your roles. Of course, it
         * is often just the "Role" model but you may use whatever you like.
         *
         * The model you want to use as a Role model needs to implement the
         * `Spatie\Permission\Contracts\Role` contract.
         */
        'role' => Spatie\Permission\Models\Role::class,
    ],

    'table_names' => [

        /*
         * Tables used by the package. You can change them if needed.
         */
        'roles' => 'roles',
        'permissions' => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [

        /*
         * Change this if you want to name the related model primary key other than `model_id`.
         * For example, if your primary keys are UUIDs, you might name this `model_uuid`.
         */
        'model_morph_key' => 'model_id',
    ],

    /*
     * When set to true, the required permission/role names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for safety.
     */
    'display_permission_in_exception' => false,
    'display_role_in_exception' => false,

    /*
     * Enable support for wildcard permissions, eg: 'users.*'
     */
    'enable_wildcard_permission' => false,

    /*
     * Cache settings for permissions & roles
     */
    'cache' => [

        /*
         * The cache key used to store all permissions.
         */
        'key' => 'spatie.permission.cache',

        /*
         * You may optionally indicate a specific cache driver to use for permission and
         * role caching using any of the `store` drivers listed in the cache.php config
         * file. Using 'default' here means to use the `default` set in cache.php.
         */
        'store' => 'default',
    ],

    /*
     * Application-specific defaults (added)
     * Ensure roles/permissions default to the 'web' guard.
     */
    'defaults' => [
        'guard' => 'web',
    ],

    /*
     * Restrict guards used by the package if desired.
     */
    'guards' => ['web'],

];
