<?php

namespace Override\FosUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OverrideFosUserBundle extends Bundle
{
public function getParent()
    {
        return 'FOSUserBundle';
    }
}