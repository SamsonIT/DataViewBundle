<?php

namespace Samson\Bundle\DataViewBundle\DataView;

use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\Exception\UnexpectedTypeException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;

abstract class AbstractDataView
{
    protected $serializableData;

    public function serializeArray($data, array $options = array())
    {
        $listedData = array();
        foreach ($data as $value) {
            $view = clone($this);
            $view->serialize($value, $options);
            $processedData = $view->getData();
            $listedData[] = $processedData;
        }
        $this->serializableData = $listedData;
    }

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
        $this->storeData($name, $resolvedProperty, $options);
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

    private function storeData($name, $data, $options)
    {

        if ($this->get($options, 'merge')) {
            $this->mergeData($name, $data, $options);
        } else {
            $this->serializableData[$name] = $data;
        }
    }

    private function mergeData($name, $data, $options)
    {
        foreach ($data as $subName => $value) {
            if ($this->get($options, 'prefix')) {
                if ($options['prefix'] === true) {
                    $subName = $name . $subName;
                } else {
                    $subName = $options['prefix'] . $subName;
                }
            }
            $this->serializableData[$subName] = $value;
        }
    }

    protected function addSet($property, $data, $name, $options = array())
    {
        $this->serializableData[$name] = array();
        $sort = $this->get($options, 'sort');
        if ($sort) {
            usort($data, $sort);
        }
        $limit = $this->get($options, 'limit');
        if ($limit) {
            $data = array_slice($data, 0, $limit, true);
        }
        foreach ($data as $entry) {
            $this->serializableData[$name][] = $this->add($property, $entry, $name, $options, true);
        }
    }

    protected function addFixed($name, $data)
    {
        $this->serializableData[$name] = $data;
    }

    private function findData($data, $property)
    {
        try {
            $value = PropertyAccess::createPropertyAccessor()->getValue($data, $property);
        }
        catch( UnexpectedTypeException $e ) {
            return null;
        }
        catch( NoSuchPropertyException $e ) {
            return null;
        }
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
