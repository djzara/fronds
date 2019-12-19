<?php


namespace Fronds\Repositories;

use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;

/**
 * Class FrondsRepository
 * @package Fronds\Repositories
 */
abstract class FrondsRepository
{

    /**
     * All repository objects in fronds can return abstract instances of their underlying models
     * @return string
     */
    abstract public function getModelClass() : string;

    /**
     * @param $id
     * @return mixed
     * @throws \Fronds\Lib\Exceptions\FrondsException
     */
    public function getById($id)
    {
        $modelClassName = static::getModelClass();
        $model = new $modelClassName();
        $entity = $model::whereId($id)->first();
        fronds_throw_if(
            $entity === null,
            FrondsEntityNotFoundException::class,
            'No entity found by that id'
        );
        return $entity;
    }
}