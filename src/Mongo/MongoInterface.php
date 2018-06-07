<?php

namespace Phalconify\Database\Mongo;

/**
 * Creates an interface to interact with several mongo client extensions.
 */
interface MongoInterface
{
    /**
     * Gets the id object to be used.
     *
     * @param string $id
     *
     * @return mixed
     *               Mongo id object to use
     */
    public function getId($id);

    /**
     * Gets the date object to be used.
     *
     * @param string $date
     *
     * @return mixed
     *               Mongo date object to use
     */
    public function getDate($date);

    /**
     * Sets the mongo connection into the dependency injection.
     *
     * @param \Phalcon\Di\FactoryDefault $di
     *                                       Dependency injection object
     */
    public function setDI(\Phalcon\Di $di, $uri = '');

    /**
     * Returns if the extension is available or not.
     *
     * @return bool
     *              True if it's available, false otherwise
     */
    public static function available();
}
