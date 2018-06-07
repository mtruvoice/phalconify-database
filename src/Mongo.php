<?php

namespace Phalconify\Database;

use Phalcon\Di as PhalconDI;
use Phalcon\Mvc\Collection\Manager;
use Phalconify\Database\Mongo\MongoInterface;
use Phalconify\Database\Mongo\Mongo as MongoExtension;
use Phalconify\Database\Mongo\MongoDB as MongoDBExtension;

/**
 * Decorator for Mongo client extensions.
 */
class Mongo implements DatabaseInterface
{
    /**
     * Mongo extension.
     *
     * @var MongoInterface
     */
    protected $mongo;

    /**
     * Constructor of the class.
     */
    public function __construct()
    {
        $this->mongo = $this->getExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function setCredentials(\Phalcon\Config $config = null)
    {
        $this->mongo->setCredentials($config);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDI(PhalconDI $di, $uri = '')
    {
        $this->mongo->setDI($di, $uri);
        $di->set('mongo-wrapper', $this->mongo);

        $di->set('collectionManager', function () {
            return new Manager();
        }, true);

        return $this;
    }

    /**
     * Returns the id object to use with this mongo instance.
     *
     * @param string $id
     *                   Id
     *
     * @return mixed
     *               Mongo id object depending on the extension currently loaded
     */
    public static function getId($id)
    {
        $mongo = \Phalcon\Di::getDefault()->get('mongo-wrapper');

        return $mongo->getId($id);
    }

    /**
     * Returns the date object to use with this mongo instance.
     *
     * @param string $date
     *                     Id
     *
     * @return mixed
     *               Mongo date object depending on the extension currently loaded
     */
    public static function getDate($date)
    {
        $mongo = \Phalcon\Di::getDefault()->get('mongo-wrapper');

        return $mongo->getDate($date);
    }

    /**
     * Loads the mongo extension to use.
     *
     * @return DatabaseInterface
     *
     * @throw \Exception
     *   In case there is no extension available to use.
     */
    protected function getExtension()
    {
        if (MongoExtension::available()) {
            return new MongoExtension();
        }
        if (MongoDBExtension::available()) {
            return new MongoDBExtension();
        }
        throw new \Exception('Unable to load a mongo db client.');
    }
}
