<?php

namespace App\Auth;

use App\Models\User;
use Framework\Core\IIdentity;
use Framework\Auth\SessionAuthenticator;
use Framework\Core\App;

class DbAuthenticator extends SessionAuthenticator
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    protected function authenticate(string $username, string $password): ?IIdentity
    {
        $users = User::getAll('`username` = ?', [$username]);
        if (empty($users)) {
            return null;
        }

        $u = $users[0];

        if (!password_verify($password, $u->getPasswordHash())) {
            return null;
        }

        return new AppIdentity((int)$u->getId(), $u->getUsername());
    }
}