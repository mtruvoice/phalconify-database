<?php

namespace Phalconify\Database\Mongo;

use Phalconify\Database\ConnectionBase;
use Phalconify\Database\DatabaseInterface;

/**
 * Mongo extension wrapper.
 */
class Mongo extends ConnectionBase implements MongoInterface, DatabaseInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId($id)
    {
        return new \MongoId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getDate($date)
    {
        $time = is_numeric($date) ? $date : strtotime($date);

        return new \MongoDate($time);
    }

    /**
     * {@inheritdoc}
     */
    public function setDI(\Phalcon\Di $di, $uri = '')
    {
        $serviceName = $this->serviceName ?? 'mongo';

        $di->set($serviceName, function () {
            if($uri !== ''){
                $mongo = new \MongoClient($uri, ['db' => $this->name]);
            } else {
                if (isset($this->username) && $this->username !== '') {
                    $mongo = new \MongoClient('mongodb://' . $this->username . ':' . $this->password . '@' . $this->host . ':' . $this->port, ['db' => $this->name]);
                } else {
                    $mongo = new \MongoClient('mongodb://' . $this->host . ':' . $this->port, ['db' => $this->name]);
                }
            }

            return $mongo->selectDb($this->name);
        }, true);
    }

    /**
     * {@inheritdoc}
     */
    public static function available()
    {
        return (bool)extension_loaded('mongo');
    }
}
