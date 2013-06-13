<?php

namespace Samson\Bundle\DataViewBundle\Entity;

class SampleEntity
{
    public function getPropertyA()
    {
        return 'a';
    }

    public function getPropertyB()
    {
        return 'b';
    }

    public function getPropertyC()
    {
        return 'c';
    }

    public function setPropertyD($d)
    {
        $this->d = $d;
    }

    public function getPropertyD()
    {
        return $this->d;
    }

    public function getNestedEntity()
    {
        return new SampleEntity;
    }

}