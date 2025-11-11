<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // ss
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * Method limit
     *
     * @param  int  $limit  [limit]
     * @param  array  $columns  [required columns]
     * @param  array  $relations  [required relations]
     */
    public function limit(int $limit, array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->limit($limit)->get($columns);
    }

    /**
     * Method paginate
     *
     * @param  int  $number  [number of records per page]
     */
    public function paginate(int $number)
    {
        return $this->model->paginate($number);
    }

    /**
     * Get all trashed models.
     */
    public function allTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * Find model by id.
     */
    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }

    /**
     * Find model by id.
     *
     * @param  array  $modelId
     * @param  array  $appends
     */
    public function findByColumn(
        array $paramsAnddData,
        array $columns = ['*'],
        array $relations = []
    ): ?Model {
        return $this->model->select($columns)->with($relations)->where($paramsAnddData)->first();
    }

    /**
     * Find model by id.
     *
     * @param  array  $modelId
     * @param  array  $appends
     */
    public function findByColumnWithTrashed(
        array $paramsAnddData,
        array $columns = ['*'],
        array $relations = []
    ): ?Model {
        return $this->model->withTrashed()->select($columns)->with($relations)->where($paramsAnddData)->first();
    }

    /**
     * Find model by columns.
     *
     * @param  array  $modelId
     * @param  array  $appends
     */
    public function getByColumn(
        array $paramsAnddData,
        array $columns = ['*'],
        array $relations = []
    ): ?Collection {
        return $this->model->select($columns)->with($relations)->where($paramsAnddData)->get();
    }

    /**
     * Find model by columns.
     *
     * @param  array  $modelId
     * @param  array  $appends
     */
    public function getCountByColumn(
        array $paramsAnddData,
        array $columns = ['*'],
        array $relations = []
    ): ?int {
        return $this->model->select($columns)->with($relations)->where($paramsAnddData)->count();
    }

    /**
     * Find model by existsByColumn.
     *
     * @param  array  $modelId
     */
    public function existsByColumn(
        array $paramsAnddData,
        array $columns = ['*']
    ): ?bool {
        return $this->model->select($columns)->where($paramsAnddData)->exists();
    }

    /**
     * Find trashed model by id.
     */
    public function findTrashedById(int $modelId): ?Model
    {
        return $this->model->withTrashed()->findOrFail($modelId);
    }

    /**
     * Find only trashed model by id.
     */
    public function findOnlyTrashedById(int $modelId): ?Model
    {
        return $this->model->onlyTrashed()->findOrFail($modelId);
    }

    /**
     * Find the latest model by specified columns and criteria.
     */
    public function findByColumnLatest(
        array $paramsAndData,
        array $columns = ['*'],
        array $relations = [],
        string $orderByColumn = 'created_at'
    ): ?Model {
        return $this->model->select($columns)
            ->with($relations)
            ->where($paramsAndData)
            ->orderBy($orderByColumn, 'desc')
            ->first();
    }

    /**
     * Create a model.
     */
    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);

        return $model->fresh();
    }

    /**
     * Create or update a model.
     */
    public function createOrUpdate(array $attributes, array $values): Model
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * Method createMany
     *
     * @param  array  $payloadCollection  [collection of payload]
     */
    public function createMany(array $payloadCollection): ?Collection
    {
        return $this->model->createMany($payloadCollection);
    }

    /**
     * Method to create multiple records.
     *
     * @param  array  $payloadCollection  [collection of payload]
     * @return Collection|null
     */
    public function createManySupport(array $payloadCollection)
    {
        $createdRecords = collect();

        foreach ($payloadCollection as $payload) {
            $createdRecords->push($this->model->create($payload));
        }

        return $createdRecords;
    }

    /**
     * Update existing model.
     */
    public function update(int $modelId, array $payload): bool
    {
        $model = $this->findById($modelId);

        return $model->update($payload);
    }

    public function updateWithTrashed(int $modelId, array $payload): bool
    {
        $model = $this->findTrashedById($modelId);

        return $model->update($payload);
    }

    /**
     * Delete model by id.
     */
    public function deleteById(int $modelId): bool
    {
        return $this->findById($modelId)->delete();
    }

    /**
     * Delete models by array of ids.
     *
     * @return void
     */
    public function deleteByIds(array $modelIds): bool
    {
        foreach ($modelIds as $modelId) {
            $this->deleteById($modelId);
        }

        return true;
    }

    /**
     * Delete model by columns.
     *
     * @return int
     */
    public function deleteByColumn(array $paramsAndData)
    {
        return $this->model->where($paramsAndData)->delete();
    }

    /**
     * Restore model by id.
     */
    public function restoreById(int $modelId): bool
    {
        return $this->findOnlyTrashedById($modelId)->restore();
    }

    /**
     * Permanently delete model by id.
     */
    public function permanentlyDeleteById(int $modelId): bool
    {
        return $this->findTrashedById($modelId)->forceDelete();
    }

    /**
     * Method filter
     *
     * @param  array  $request  [Http Request]
     * @param  array  $with  [Relations]
     */
    public function filter($filters, $with = []): LengthAwarePaginator
    {
        $query = $this->model->filter($filters)->orderByColumn($filters['sortBy'], $filters['sortDirection']);
        if (count($with) > 0) {
            $query = $query->with($with);
        }

        return $query->paginate($filters['rowPerPage'])->appends($filters);
    }
}
