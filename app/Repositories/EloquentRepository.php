<?php


namespace App\Repositories;


class EloquentRepository implements RepositoryInterface
{
    protected $model;

    /**
     * BaseRepository constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->model->all()->count();
    }

    /**
     * @param $column
     * @param $value
     * @return mixed
     */
    public function where($column, $value)
    {
         return $this->model->where($column, $value)->get();
    }

    /**
     * @param $column
     * @param $operator
     * @param $value
     * @return mixed
     */
    public function whereCompare($column, $operator, $value)
    {
        return $this->model->where($column, $operator, $value);

    }
}
