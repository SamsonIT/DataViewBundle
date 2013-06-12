<?php

namespace Samson\Bundle\DataViewBundle\DataView;

class SampleDataViewArray extends AbstractDataView
{
    public function serialize($data, array $options = array())
    {
        $this->add('propertyA', $data );
        $this->addSet('propertyD', $data->getSet(), 'set', $options );
    }

}