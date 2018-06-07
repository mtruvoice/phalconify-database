<?php

namespace Phalconify\Database\Mongo;

use Phalconify\Database\ConnectionBase;
use Phalconify\Database\DatabaseInterface;

/**
 * MongoDB extension wrapper.
 */
class MongoDB extends ConnectionBase implements MongoInterface, DatabaseInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId($id)
    {
        /**
         * Strtolower to remove when this bug is fixed.
         *
         * @see https://jira.mongodb.org/browse/PHPC-620
         */
        $id = strtolower($id);

        return new \MongoDB\BSON\ObjectID($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getDate($date)
    {
        $time = is_numeric($date) ? $date : (strtotime($date) * 1000);

        return new \MongoDB\BSON\UTCDateTime($time);
    }

    /**
     * {@inheritdoc}
     */
    public function setDI(\Phalcon\Di $di, $uri = '')
    {
        if($uri === ''){
            if (isset($this->username) && $this->username !== '') {
                $uri = 'mongodb://' . $this->username . ':' . $this->password . '@' . $this->host . ':' . $this->port . '/' . $this->name;
            } else {
                $uri = 'mongodb://' . $this->host . ':' . $this->port . '/' . $this->name;
            }
        }

        $database = $this->name;
        $serviceName = $this->serviceName ?? 'mongo';

        $di->set($serviceName, function () use ($uri, $database) {
            $mongo = new \Phalcon\Db\Adapter\MongoDB\Client($uri);

            return $mongo->selectDatabase($database);
        }, true);
    }

    /**
     * {@inheritdoc}
     */
    public static function available()
    {
        return (bool)extension_loaded('mongodb');
    }
}
