<?php

namespace Privateer\Uuid;

use Webpatser\Uuid\Uuid;

/**
 * Class EloquentUuid
 * @package Privateer\Uuid
 */
trait EloquentUuid
{
    /**
     *
     */
    protected static function bootEloquentUuid()
    {
        /**
         * Attach to the 'creating' Model Event to provide a UUID
         * for the `uuid` field
         */
        static::creating(function ($model) {

            $columnName = static::getUuidColumn();

            $model->$columnName = ( $model->getAttribute($columnName)) ? $model->getAttribute($columnName) : Uuid::generate(4);
        });
    }


    /**
     * @param $uuid
     * @return mixed
     */
    public static function findByUuid($uuid)
    {
        return static::where(static::getUuidColumn(), $uuid)->firstOrFail();
    }

    /**
     * @return mixed
     */
    public function getUuidAttribute()
    {
        $columnName = static::getUuidColumn();

        return ( ! empty($this->attributes[$columnName])) ? (string) $this->attributes[$columnName] : false;
    }

    /**
     * @return string
     */
    protected static function getUuidColumn()
    {
        if(isset(static::$uuidColumn))
        {
            return static::$uuidColumn;
        }

        return 'uuid';
    }
}