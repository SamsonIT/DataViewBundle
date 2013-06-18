<?php

namespace Samson\Bundle\DataViewBundle\Entity;

class SampleNestingEntity
{
    public function getPropertyD()
    {
        return 'd';
    }

    public function getPropertyE()
    {
        return 'e';
    }

    public function getPropertyF()
    {
        return 'f';
    }

    public function getNestedEntity()
    {
        return new SampleEntity;
    }

}