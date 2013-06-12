<?php

namespace Samson\Bundle\DataViewBundle\DataView;

use Symfony\Component\PropertyAccess\Exception\UnexpectedTypeException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;

abstract class AbstractDataView
{
    protected $serializableData;

    abstract public function serialize($data, array $options = array());

    protected function add($property, $data, $name = null, $options = array(), $return = false)
    {
        if (is_string($property)) {
            if (null === $name) {
                $name = $property;
            }
            $resolvedProperty = $this->addProperty($property, $data, $options);
        } elseif (is_object($property)) {
            if (null === $name) {
                $name = get_class($property);
            }
            $resolvedProperty = $this->addSubView($property, $data, $options);
        }
        if ($return) {
            return $resolvedProperty;
        }
        $this->serializableData[$name] = $resolvedProperty;
    }

    private function addProperty($property, $data, $options)
    {
        if (null === $data) {
            return null;
        }
        $propertyPath = new PropertyPath($property);
        return $this->findData($data, $propertyPath);
    }

    private function addSubView($view, $data, $options)
    {
        if (null === $data) {
            return null;
        }
        $view->serialize($data, $options);
        return $view->getData();
    }

    protected function addSet($property, $data, $name, $options = array())
    {
        $this->serializableData[$name] = array();
        $sort = $this->get( $options, 'sort');
        if( $sort ) {
            usort( $data, $sort );
        }
        $limit = $this->get( $options, 'limit');
        if( $limit ) {
            $data = array_slice( $data, 0, $limit, true );
        }
        foreach ($data as $entry) {
            $this->serializableData[$name][] = $this->add($property, $entry, $name, $options, true);
        }
    }

    private function findData($data, $property)
    {
        $value = PropertyAccess::createPropertyAccessor()->getValue($data, $property);
return $value;
}

public function getData()
{
    return $this->serializableData;
}

protected function get($options, $option, $default = null)
{
    if (isset($options[$option])) {
        return $options[$option];
    }
    return $default;
}
}
