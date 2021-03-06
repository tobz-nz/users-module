<?php namespace Anomaly\UsersModule\Role\Permission;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\UsersModule\Role\Contract\RoleInterface;
use Illuminate\Config\Repository;
use Illuminate\Translation\Translator;

/**
 * Class PermissionFormFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\UsersModule\Role\Permission
 */
class PermissionFormFields
{

    /**
     * Handle the fields.
     *
     * @param PermissionFormBuilder $builder
     * @param AddonCollection       $addons
     * @param Translator            $translator
     * @param Repository            $config
     */
    public function handle(
        PermissionFormBuilder $builder,
        AddonCollection $addons,
        Translator $translator,
        Repository $config
    ) {
        /* @var RoleInterface $role */
        $role = $builder->getEntry();

        $fields = [];

        $namespaces = ['streams'];

        /* @var Addon $addon */
        foreach ($addons->withConfig('permissions') as $addon) {
            $namespaces[] = $addon->getNamespace();
        }

        foreach ($namespaces as $namespace) {
            foreach ($config->get($namespace . '::permissions', []) as $group => $permissions) {

                $label = $namespace . '::permission.' . $group . '.name';

                if (!$translator->has($warning = $namespace . '::permission.' . $group . '.warning')) {
                    $warning = null;
                }

                if (!$translator->has($instructions = $namespace . '::permission.' . $group . '.instructions')) {
                    $instructions = null;
                }

                $fields[$namespace . '::' . $group] = [
                    'label'        => $label,
                    'warning'      => $warning,
                    'instructions' => $instructions,
                    'type'         => 'anomaly.field_type.checkboxes',
                    'value'        => function () use ($role, $namespace, $group) {
                        return array_map(
                            function ($permission) use ($role, $namespace, $group) {
                                return str_replace($namespace . '::' . $group . '.', '', $permission);
                            },
                            $role->getPermissions()
                        );
                    },
                    'config'       => [
                        'options' => function () use ($group, $permissions, $namespace) {
                            return array_combine(
                                $permissions,
                                array_map(
                                    function ($permission) use ($namespace, $group) {
                                        return $namespace . '::permission.' . $group . '.option.' . $permission;
                                    },
                                    $permissions
                                )
                            );
                        }
                    ]
                ];
            }
        }

        $builder->setFields($fields);
    }
}
