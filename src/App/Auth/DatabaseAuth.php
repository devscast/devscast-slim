<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */



namespace App\Auth;

use App\Repositories\UsersRepository;
use Core\Auth\AuthInterface;
use Core\Auth\User;
use Core\Session\SessionInterface;

/**
 * Class DatabaseAuth
 * @package App\Auth
 */
class DatabaseAuth implements AuthInterface
{

    /**
     * @var UsersRepository
     */
    private $users;
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * User session cache
     * @var user;
     */
    private $user;

    /**
     * DatabaseAuth constructor.
     * @param UsersRepository $users
     * @param SessionInterface $session
     */
    public function __construct(UsersRepository $users, SessionInterface $session)
    {
        $this->users = $users;
        $this->session = $session;
    }

    /**
     * Return a user if credentials are correct
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function login(string $email, string $password): ?User
    {
        if (!empty($email) || !empty($password)) {
            $user = $this->users->findWith('email', $email);

            if ($user && password_verify($password, $user->password)) {
                $this->session->set('auth.user', $user->id);
                return $user;
            }
        }
        return null;
    }

    /**
     * Logout a user
     */
    public function logout()
    {
        $this->session->delete('auth.user');
    }

    /**
     * Retrieve a logged user or null
     * @return User|null
     */
    public function getUser(): ?User
    {
        if (!$this->user) {
            $userId = $this->session->get('auth.user');
            if ($userId) {
                return $this->users->find($userId);
            }
            return null;
        }
        return $this->user;
    }
}
