<?php

namespace Samson\Bundle\DataViewBundle\DataView;

use Symfony\Component\Form\Exception;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\ResolvedFormTypeFactoryInterface;
use Symfony\Component\Form\ResolvedFormTypeInterface;

class ResolvedTypeFactory implements ResolvedFormTypeFactoryInterface
{

    public function createResolvedType(FormTypeInterface $type, array $typeExtensions, ResolvedFormTypeInterface $parent = null)
    {
        return new ResolvedDataViewType($type, $typeExtensions, $parent);
    }
}
