<?php
namespace Samson\Bundle\DataViewBundle\DataView;


use Symfony\Component\Form\Exception;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\ResolvedFormTypeFactoryInterface;
use Symfony\Component\Form\ResolvedFormTypeInterface;

class ResolvedTypeFactory implements ResolvedFormTypeFactoryInterface {
    /**
     * Resolves a form type.
     *
     * @param FormTypeInterface $type
     * @param FormTypeExtensionInterface[] $typeExtensions
     * @param ResolvedFormTypeInterface|null $parent
     *
     * @return ResolvedFormTypeInterface
     *
     * @throws Exception\UnexpectedTypeException  if the types parent {@link FormTypeInterface::getParent()} is not a string
     * @throws Exception\InvalidArgumentException if the types parent can not be retrieved from any extension
     */
    public function createResolvedType(FormTypeInterface $type, array $typeExtensions, ResolvedFormTypeInterface $parent = null)
    {
        return new ResolvedDataViewType($type, $typeExtensions, $parent);
    }

} 