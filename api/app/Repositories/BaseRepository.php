<?php
namespace Repository;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

Abstract class BaseRepository {

    abstract function model();

    public function getAll($offset, $limit, $searchData = null, $option = null)
    {
        $query = $this->model()::query();
        $this->applyDefaultCriteria($query);

        switch ($option) {
            case 'list':
                $result = $this->paginateResult($query, $offset, $limit);
                break;

            case 'search':
                if ($searchData) {
                    $this->applySearchCriteria($query, $searchData);
                }
                $result = $this->paginateResult($query, $offset, $limit);
                break;

            default:
                $result = $query->get();
                break;
        }

        if ($result->isEmpty()) {
            throw new \RuntimeException('No records found.');
        }

        return ['result' => $result, 'count' => $this->getTotalCount($query, $limit)];
    }

    protected function applyDefaultCriteria($query)
    {
        $query->orderBy('created_at', 'desc');
    }

    protected function applySearchCriteria($query, $searchData)
    {
        $searchFields = $this->getSearchFields();
        $query->where(function ($query) use ($searchFields, $searchData) {
            foreach ($searchFields as $field) {
                $query->orWhere($field, 'like', '%' . $searchData . '%');
            }
        });
    }

    protected function paginateResult($query, $offset, $limit)
    {
        return $query->offset(($offset - 1) * $limit)
            ->limit($limit)
            ->get();
    }

    protected function getTotalCount($query, $limit)
    {
        return $query->paginate($limit)->total();
    }

    protected function getSearchFields()
    {
        return [];
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
        $model->update($modelData);
        $model->refresh();
        return $model;
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
