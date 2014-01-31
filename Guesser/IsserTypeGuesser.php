<?php

namespace Samson\Bundle\DataViewBundle\Guesser;

use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Form\Guess\Guess;
use Symfony\Component\Form\Guess\TypeGuess;

class IsserTypeGuesser implements FormTypeGuesserInterface
{
    /**
     * If a property has an isser or a hasser and not getter, it is assumed to be a boolean type
     *
     * @param string $class    The fully qualified class name
     * @param string $property The name of the property to guess for
     *
     * @return TypeGuess|null A guess for the field's type and options
     */
    public function guessType($class, $property)
    {
        $reflClass = new \ReflectionClass($class);
        if ($reflClass->hasProperty($property)) {
            $reflProp = $reflClass->getProperty($property);
            if ($reflProp->isPublic()) {
                return null;
            }
        }

        if (!$reflClass->hasMethod('get' . ucfirst($property)) && ($reflClass->hasMethod('is' . ucfirst($property)) || $reflClass->hasMethod('has' . ucfirst($property)))) {
            return new TypeGuess('boolean', array(), Guess::HIGH_CONFIDENCE);
        }
    }

    public function guessRequired($class, $property)
    {
        // not used
    }

    public function guessMaxLength($class, $property)
    {
        // not used
    }

    public function guessPattern($class, $property)
    {
        // not used
    }
}
