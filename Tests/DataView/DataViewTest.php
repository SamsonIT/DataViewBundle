<?php

namespace Samson\Bundle\DataViewBundle\Tests;

use Samson\Bundle\DataViewBundle\DataView\SampleDataView;
use Samson\Bundle\DataViewBundle\DataView\SampleMergeView;
use Samson\Bundle\DataViewBundle\DataView\SampleMergePrefixedView;
use Samson\Bundle\DataViewBundle\DataView\SampleDataViewAdvanced;
use Samson\Bundle\DataViewBundle\DataView\SampleDataViewArray;
use Samson\Bundle\DataViewBundle\DataView\SampleDataViewOptions;
use Samson\Bundle\DataViewBundle\DataView\SampleDataViewUnknown;
use Samson\Bundle\DataViewBundle\Entity\SampleArrayEntity;
use Samson\Bundle\DataViewBundle\Entity\SampleEntity;
use Samson\Bundle\DataViewBundle\Entity\SampleNestingEntity;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;

class DataViewTest extends \PHPUnit_Framework_TestCase
{

    public function testBasicView()
    {

        $entity = new SampleEntity();
        $dataview = new SampleDataView();

        $dataview->serialize($entity);
        $data = $dataview->getData();

        $this->assertEquals(array('propertyA' => 'a', 'propertyB' => 'b', 'propertyC' => 'c'), $data);

    }

    public function testNestedView()
    {

        $entity = new SampleEntity();
        $dataview = new SampleDataViewAdvanced();

        $dataview->serialize($entity);
        $data = $dataview->getData();

        $this->assertEquals(array('propertyA' => 'a', 'nested' => array('propertyA' => 'a', 'propertyB' => 'b', 'propertyC' => 'c')), $data);

    }

    public function testOptionsView()
    {

        $entity = new SampleEntity();
        $dataview = new SampleDataViewOptions();

        $dataview->serialize($entity, array('showB' => true));
        $data = $dataview->getData();

        $this->assertEquals(array('propertyA' => 'a', 'propertyB' => 'b'), $data);

    }

    public function testNonExistant()
    {

        $entity = new SampleEntity();
        $dataview = new SampleDataViewUnknown();

        $dataview->serialize($entity);
        $data = $dataview->getData();
        $this->assertEquals( array( 'propertyZ' => null ), $data );

    }

    public function testSetView()
    {

        $entity = new SampleArrayEntity();
        $dataview = new SampleDataViewArray();

        $dataview->serialize($entity);
        $data = $dataview->getData();

        $this->assertEquals(array('propertyA' => 'a', 'set' => array(
            1,
            2,
            3,
            4,
            5,
        )), $data);

    }

    public function testSetViewWithLimit()
    {

        $entity = new SampleArrayEntity();
        $dataview = new SampleDataViewArray();

        $dataview->serialize($entity, array('limit' => 3));
        $data = $dataview->getData();

        $this->assertEquals(array('propertyA' => 'a', 'set' => array(
            1,
            2,
            3,
        )), $data);

    }

    public function testSetViewWithSort()
    {

        $entity = new SampleArrayEntity();
        $dataview = new SampleDataViewArray();

        $dataview->serialize($entity, array('sort' => function ($a, $b) {
            return $b > $a;
        }));
        $data = $dataview->getData();

        $this->assertEquals(array('propertyA' => 'a', 'set' => array(
            5,
            4,
            3,
            2,
            1,
        )), $data);

    }

    public function testSetViewWithSortAndLimit()
    {

        $entity = new SampleArrayEntity();
        $dataview = new SampleDataViewArray();

        $dataview->serialize($entity, array('sort' => function ($a, $b) {
            return $b > $a;
        }, 'limit' => 3));
        $data = $dataview->getData();

        $this->assertEquals(array('propertyA' => 'a', 'set' => array(
            5,
            4,
            3,
        )), $data);
    }

    public function testMergingView()
    {
        $entity = new SampleNestingEntity();
        $dataview = new SampleMergeView();

        $dataview->serialize($entity);
        $data = $dataview->getData();

        $this->assertEquals(array('propertyA' => 'a', 'propertyB' => 'b', 'propertyC' => 'c', 'propertyD' => 'd', 'propertyE' => 'e', 'propertyF' => 'f'), $data);

    }

    public function testMergingPrefixedView()
    {
        $entity = new SampleNestingEntity();
        $dataview = new SampleMergePrefixedView();

        $dataview->serialize($entity, array('prefix' => '_'));
        $data = $dataview->getData();

        $this->assertEquals(array('_propertyA' => 'a', '_propertyB' => 'b', '_propertyC' => 'c', 'propertyD' => 'd', 'propertyE' => 'e', 'propertyF' => 'f'), $data);

    }

    public function testMergingAutoPrefixedView()
    {
        $entity = new SampleNestingEntity();
        $dataview = new SampleMergePrefixedView();

        $dataview->serialize($entity, array('prefix' => true));
        $data = $dataview->getData();

        $this->assertEquals(array('nestedpropertyA' => 'a', 'nestedpropertyB' => 'b', 'nestedpropertyC' => 'c', 'propertyD' => 'd', 'propertyE' => 'e', 'propertyF' => 'f'), $data);

    }

    public function testArrayOfDataView()
    {
        $entities = array();
        for ($i = 0; $i < 10; $i++) {
            $entities[] = new SampleEntity();
        }
        $dataview = new SampleDataView();

        $dataview->serializeArray($entities);
        $data = $dataview->getData();

        $this->assertEquals(10, count($data));
        for ($i = 0; $i < 10; $i++) {
            $this->assertEquals(array('propertyA' => 'a', 'propertyB' => 'b', 'propertyC' => 'c'), $data[$i]);
        }

    }

}