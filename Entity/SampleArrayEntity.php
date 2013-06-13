<?php

namespace Samson\Bundle\DataViewBundle\Entity;

class SampleArrayEntity
{
    public function getPropertyA()
    {
        return 'a';
    }

    public function getSet()
    {
        $a = new SampleEntity;
        $a->setPropertyD(1);
        $b = new SampleEntity;
        $b->setPropertyD(2);
        $c = new SampleEntity;
        $c->setPropertyD(3);
        $d = new SampleEntity;
        $d->setPropertyD(4);
        $e = new SampleEntity;
        $e->setPropertyD(5);

        return array(
            $a, $b, $c, $d, $e
        );
    }


}