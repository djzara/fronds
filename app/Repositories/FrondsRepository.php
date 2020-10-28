<?php

declare(strict_types=1);


namespace Fronds\Repositories;

use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Lib\Exceptions\Usage\FrondsIllegalArgumentException;
use Fronds\Models\Page;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

use function array_key_exists;

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

    /**
     * @param  array|string  $relationNames
     * @param  array|string[]  $columns
     * @param  array|string[]  $orderBy
     * @param  int  $limit
     * @return Collection
     * @throws FrondsException
     */
    public function getAllWithRelations(
        $relationNames,
        array $columns = ['*'],
        array $orderBy = ['column' => '', 'dir' => 'ASC'],
        int $limit = 0
    ): Collection {
        // let exceptions bubble up from getAll
        $results = $this->getAll($columns, $orderBy, $limit);
        return $results->load($relationNames);
    }

    /**
     * @param  array  $columns
     * @param  int  $pageSize
     * @param  string  $pageName
     * @return LengthAwarePaginator
     * @throws FrondsException
     */
    public function getAllPaginated(
        array $columns = ['*'],
        int $pageSize = 10,
        string $pageName = ''
    ): LengthAwarePaginator {
        fronds_throw_unless(
            $pageSize >= 0,
            FrondsIllegalArgumentException::class,
            'Invalid page size. Should be greater than or equal to 0'
        );
        $modelClass = static::getModelClass();
        return $modelClass::paginate($pageSize, $columns, ['pagination_'.$pageName]);
    }

    /**
     * @param $relationNames
     * @param  array  $columns
     * @param  int  $pageSize
     * @param  string  $pageName
     * @return Collection
     * @throws FrondsException
     */
    public function getAllPaginatedWithRelations(
        $relationNames,
        array $columns = ['*'],
        int $pageSize = 10,
        string $pageName = ''
    ): Collection {
        $results = $this->getAllPaginated($columns, $pageSize, $pageName);
        return $results->load($relationNames);
    }
}
