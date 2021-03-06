<?php namespace Anomaly\UsersModule\User\Command;

use Anomaly\UsersModule\User\Contract\UserInterface;
use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class ActivateUserByForce
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\UsersModule\User\Command
 */
class ActivateUserByForce implements SelfHandling
{

    /**
     * The user instance.
     *
     * @var UserInterface
     */
    protected $user;

    /**
     * Create a new ActivateUserByForce instance.
     *
     * @param UserInterface $user
     */
    function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the command.
     *
     * @param UserRepositoryInterface $users
     * @return bool
     */
    public function handle(UserRepositoryInterface $users)
    {
        $this->user->activated       = true;
        $this->user->activation_code = null;

        $users->save($this->user);

        return true;
    }
}
