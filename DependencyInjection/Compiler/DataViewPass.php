<?php

namespace Samson\Bundle\DataViewBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DataViewPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('samson.dataview.extension')) {
            return;
        }

        $definition = $container->getDefinition('samson.dataview.extension');

        // Builds an array with service IDs as keys and tag aliases as values
        $types = array();

        foreach ($container->findTaggedServiceIds('samson.dataview.type') as $serviceId => $tag) {
            $alias = isset($tag[0]['alias'])
                ? $tag[0]['alias']
                : $serviceId;

            // Flip, because we want tag aliases (= type identifiers) as keys
            $types[$alias] = $serviceId;
        }

        $definition->replaceArgument(1, $types);

        $typeExtensions = array();

        foreach ($container->findTaggedServiceIds('samson.dataview.type_extension') as $serviceId => $tag) {
            $alias = isset($tag[0]['alias'])
                ? $tag[0]['alias']
                : $serviceId;

            $typeExtensions[$alias][] = $serviceId;
        }

        $definition->replaceArgument(2, $typeExtensions);

        // Find all services annotated with "samson.dataview.type_guesser"
        $guessers = array_keys($container->findTaggedServiceIds('samson.dataview.type_guesser'));

        $definition->replaceArgument(3, $guessers);
    }
}
