<?php

namespace Viweb\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ViwebUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
