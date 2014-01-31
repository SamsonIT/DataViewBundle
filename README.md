README
======

Example of use
--------------

```
// class
class SampleDataView extends AbstractType
{
    public function getName()
    {
        return 'sample';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name_of_key', 'type_of_key', array('property_path' => 'optionalPath', /** other options */))
            ->add('children', 'collection', array('type' => new ChildDataView())
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $e) {
            $e->getForm()->add('new_key', 'type_of_key', array('mapped' => false, 'data' => $e->getData()->getSomeCustomData());
        }
    }
}

// use
$view = $container->get('samson.dataview.factory')->create(new SampleDataView(), $sample);
$data = $view->createView()->getData();

// $data is now something like:
// array( 'name_of_key' => 'value_of_$entity->getOptionalPath()', 'children' => array(array(), array(), array(), 'etc' ), 'new_key' => 'value_of_$entity->getSomeCustomData()' );

```
Introduction
--------------

The DataViewBundle is based in great upon the Form component in symfony. It makes use of the FormView part to convert
an object scheme into a basic array, making full use of the flexibility the Form component offers.

A problem often encountered, for example, is having a situation where you want to serialize a "Project" entity with all
it's "Product" children in one controller, and a "Product" entity with it's "Product" parent in the other. In order to
prevent an endless serialization loop, either make use of the options to tell each type what to include and what not,
or simply add the relevant fields to the View from the controller.
