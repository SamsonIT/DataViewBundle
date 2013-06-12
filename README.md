README
======

Introduction
--------------

To get a quick idea of what a DataView looks like, check out the various Samples in the DataView folder.

The DataView bundle is a configuration handler that works together with the serialization tool of your choice to
serialize various entities and arrays. It´s an ideal tool when you need to communicate a lot of entity data to your
frontend.

I personally recommend JMS/Serializer, but any should work.

How to use
----------

- First, create a new class and make it extend AbstractDataView
- Implement a serialize() method to determine properties to serialize
- Use ->add and ->addSet to pick properties and arrays of properties that you want added
- Use $options to get some more control over which properties need to be included
- Use getData() to get a data map, then run that through your serializer of choice

Nesting
-------

DataViews can be nested. Instead of a propertyName, you can add a new DataView().
All the contents of the nested dataview will be added to a single element of the parent.
Nesting works with both add (which will add a single subview) and addSet (which will add an array of subviews)
$options can be passed to the subview as usual.