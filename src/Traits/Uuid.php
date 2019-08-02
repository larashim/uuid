<?php

namespace Larashim\Uuid\Traits;

use Illuminate\Support\Str;

trait Uuid
{
    /**
     * Boot trait.
     *
     * @return void
     */
    protected static function bootUuid()
    {
        static::creating(static function ($model) {
            $model->{$model->getUuidKey()} = (string) ($model->wantsOrderedUuid() ? Str::orderedUuid() : Str::uuid());
        });
    }

    /**
     * A query scope to find a model by UUID.
     *
     * @return self;
     */
    public function scopeFindUuid($query, $uuid)
    {
        return $query->where($this->getUuidKey(), $uuid)->first();
    }

    /**
     * Get the casts array.
     *
     * @return array
     */
    public function getCasts()
    {
        $this->casts[$this->getUuidKey()] = 'uuid';

        return $this->casts;
    }

    /**
     * Returns true if the model should use an ordered UUID.
     *
     * @return string
     */
    protected function wantsOrderedUuid()
    {
        return $this->uuidOrdered ?? true;
    }

    /**
     * Get the defined uuid name attribute.
     *
     * @return string
     */
    protected function getUuidKey()
    {
        return $this->uuidKey ?? 'uuid';
    }
}
