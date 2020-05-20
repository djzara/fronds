<?php


namespace Fronds\Repositories;

use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Lib\Exceptions\Usage\FrondsIllegalArgumentException;
use Illuminate\Database\Eloquent\Collection;

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
    abstract public function getModelClass(): string;

    /**
     * @param $id
     * @return mixed
     * @throws FrondsException
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

    /**
     * @param  array  $columns
     * @param  array  $orderBy
     * @param  int  $limit
     * @return Collection
     * @throws FrondsException
     */
    public function getAll(
        array $columns = ['*'],
        array $orderBy = ['column' => '', 'dir' => 'ASC'],
        int $limit = 0
    ): Collection {
        $modelClassName = static::getModelClass();
        $allEntityBuilder = $modelClassName::select($columns);
        fronds_throw_if(
            !array_key_exists('column', $orderBy),
            FrondsIllegalArgumentException::class,
            'Order By column not specified'
        );
        fronds_throw_if(
            !array_key_exists('dir', $orderBy),
            FrondsIllegalArgumentException::class,
            'Order By direction not specified'
        );

        if ($orderBy['column'] !== '') {
            $allEntityBuilder->orderBy($orderBy['column'], $orderBy['dir']);
        }
        return $allEntityBuilder->limit($limit)->get();
    }
}
