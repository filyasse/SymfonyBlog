<?php

namespace Ilyasse\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class IlyasseUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
