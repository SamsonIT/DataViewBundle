<?php

namespace Samson\Bundle\DataViewBundle;

use Samson\Bundle\DataViewBundle\DependencyInjection\Compiler\DataViewPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SamsonDataViewBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DataViewPass());
    }
}
