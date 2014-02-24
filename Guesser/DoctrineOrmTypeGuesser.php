<?php

namespace Samson\Bundle\DataViewBundle\Guesser;

use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Form\DoctrineOrmTypeGuesser as BaseGuesser;
use Symfony\Component\Form\Guess\Guess;
use Symfony\Component\Form\Guess\TypeGuess;

class DoctrineOrmTypeGuesser extends BaseGuesser
{
    /**
     * Returns a field guess for a property name of a class. It is based in great part upon the guesser with the same
     * name in symfony core, but some guesses are updated to match DataView types before returned to the factory.
     *
     * @param string $class    The fully qualified class name
     * @param string $property The name of the property to guess for
     *
     * @return TypeGuess|null A guess for the field's type and options
     */
    public function guessType($class, $property)
    {
        if (!$ret = $this->getMetadata($class)) {
            return new TypeGuess('text', array(), Guess::LOW_CONFIDENCE);
        }

        list($metadata, $name) = $ret;

        /** @var $metadata ClassMetadata */
        $idFieldNames = $metadata->getIdentifierFieldNames();
        if (count($idFieldNames) == 1 && $property == $idFieldNames[0]) {
            return new TypeGuess('id', array('class' => $class), Guess::HIGH_CONFIDENCE);
        }

        $guess = parent::guessType($class, $property);

        $options = $guess->getOptions();

        switch ($guess->getType()) {
            case 'number':
                return new TypeGuess('float',$guess->getOptions(), $guess->getConfidence());
            case 'entity':
                if ($options['multiple']) {
                    return new TypeGuess('collection', array('type' => 'entity', 'options' => array('data_class' => $options['class'])), $guess->getConfidence());
                }

                return new TypeGuess('entity', array('data_class' => $options['class']), $guess->getConfidence());
            case 'textarea':
                return new TypeGuess('text', $guess->getOptions(), $guess->getConfidence());
            case 'checkbox':
                return new TypeGuess('boolean', $guess->getOptions(), $guess->getConfidence());
            default:
                return new TypeGuess($guess->getType(), $guess->getOptions(), $guess->getConfidence());
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
