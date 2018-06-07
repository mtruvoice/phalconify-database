<?php

/*
** Base connection class
*/

namespace Phalconify\Database;

abstract class ConnectionBase
{
    public $serviceName;
    public $host;
    public $name;
    public $username;
    public $password;
    public $port;

    /**
     * Loads the database credentials from the configuration di.
     *
     * @method setCredentials
     */
    public function setCredentials(\Phalcon\Config $config)
    {
        if ($config === null) {
            return false;
        }
        $this->serviceName = $config->serviceName ?? null;
        $this->host = $config->host;
        $this->name = $config->name;
        $this->username = $config->username;
        $this->password = $config->password;
        $this->port = $config->port;

        return $this;
    }
}
