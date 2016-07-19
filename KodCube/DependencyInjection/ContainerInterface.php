<?php
namespace KodCube\DependencyInjection;

/**
 * Describes the interface of a container that exposes methods to read its entries.
 */
interface ContainerInterface
{

    /**
     * Finds an entry of the container by its identifier or class name and returns it.
     *
     * @param string $id Identifier/Class Name of the entry to look for.
     *
     * @throws NotFoundException  No entry was found for this identifier.
     * @throws ContainerException Error while retrieving the entry.
     *
     * @return mixed Entry.
     */

    public function __invoke(string $id,...$args);


    /**
     * Method Access to Container Aliases
     *
     * @param string $id
     * @param $args
     *
     * @throws NotFoundException  No entry was found for this identifier.
     * @throws ContainerException Error while retrieving the entry.
     *
     * @return mixed
     */

    public function __call(string $id,array $args);
    
    
    
    /**
     * Build Object and Inject Dependencies
     * 
     * @param string $className Class Name
     * @param array $args Arguments to constructor
     */

    public function make($className,...$args);

}
