<?php

/*
** Interface for database classes
*/

namespace Phalconify\Database;

interface DatabaseInterface
{
    /**
     * Sets mongo credentials from the configuration.
     *
     * @param \Phalcon\Config $config
     *
     * @return $this
     */
    public function setCredentials(\Phalcon\Config $config);

    /**
     * Inject the mongo client to the phalcon container service.
     *
     * @param Phalcon\Di $di
     *                       The phalcon dependency injection service
     *
     * @return Phalcon\Di $di
     *                    The phalcon dependency injection service with database connection service
     */
    public function setDI(\Phalcon\Di $di);
}
