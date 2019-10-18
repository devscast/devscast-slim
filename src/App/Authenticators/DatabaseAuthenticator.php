<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Authenticators;

use Modules\User\UsersRepository;
use Framework\Auth\AuthInterface;
use Framework\Auth\UserInterface;
use Framework\Session\SessionInterface;

/**
 * Class DatabaseAuthenticator
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package App\Authenticators
 */
class DatabaseAuthenticator implements AuthInterface
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
     * @var userInterface;
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
     * @return UserInterface|null
     */
    public function login(string $email, string $password): ?UserInterface
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
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
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
