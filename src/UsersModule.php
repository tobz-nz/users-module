<?php namespace Anomaly\UsersModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

/**
 * Class UsersModule
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\UsersModule
 */
class UsersModule extends Module
{

    /**
     * The module icon.
     *
     * @var string
     */
    protected $icon = 'users';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'users'  => [
            'buttons' => [
                'new_user'
            ]
        ],
        'roles'  => [
            'buttons' => [
                'new_role'
            ]
        ],
        'fields' => [
            'buttons' => [
                'add_field' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'href'        => 'admin/users/fields/choose'
                ]
            ]
        ]
    ];

}
