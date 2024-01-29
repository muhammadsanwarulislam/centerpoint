<?php
namespace Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

Abstract class BaseRepository {

    abstract function model();

    public function getAll()
    {
        return $this->model()::orderBy('id', 'desc')->paginate(20);
    }

    public function findByID($id): Model
    {
        return $this->model()::find($id);
    }

    public function findOrFailByID($id): Model
    {
        return $this->model()::findOrFail($id);
    }

    public function create(array $modelData)
    {
        return $this->model()::create($modelData);
    }

    public function updateByID($id, array $modelData)
    {
        $model = $this->findOrFailByID($id);
        return $model->update($modelData);
    }

    public function deletedByID($id)
    {
        $model = $this->findOrFailByID($id);
        return $model->delete();
    }

    public function updateAndReloadByID($id, array $modelData)
    {
        $model = $this->findOrFailByID($id);
        $model->update($modelData);
        return $model->reload();
    }
    
    public function getAllByUserID($field, $id)
    {
        return $this->model()::where($field, $id)->get();
    }

    function updateByModelCondition($condition, $field, $value)
    {
        return $this->model()::where($condition)->update([$field => $value]);
    }
}
