<?php

namespace Privateer\Uuid;

/**
 * Class UuidRepository
 * @package Privateer\Uuid
 */
trait UuidRepository
{
    /**
     * @param $uuid
     * @return mixed
     */
    public function get($uuid)
    {
        $class = $this->getRepositoryClass();

        if (isset($this->getWith)) {
            return $class::with($this->getWith)->where($class::getUuidColumn(), $uuid)->firstOrFail();
        }

        return $class::where($class::getUuidColumn(), $uuid)->firstOrFail();
    }

    public function getRepositoryClass()
    {
        if(isset($this->repositoryClass)) return $this->repositoryClass;

        return str_replace('Repository', '', get_class($this));
    }

    public function update($uuid, $formData)
    {
        $model = $this->get($uuid);

        $model->fill($formData);

        $model->save();
    }
}