<?php
namespace Repository;

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
        $searchFields = [];

        if ($this->model() == User::class) {
            $query->where('id', '<>', Auth::id())->orderBy('created_at', 'desc');
            $searchFields = ['username', 'email'];
        } elseif ($this->model() == Role::class) {
            $query->orderBy('created_at', 'desc');
            $searchFields = ['name'];
        } 

        switch ($option) {
            case 'list':
                $result = $query->offset(($offset - 1) * $limit)
                    ->limit($limit)
                    ->get();
                $count = $query->paginate($limit)->total();
                break;

            case 'search':
                if ($searchData) {
                    $query->where(function ($query) use ($searchFields, $searchData) {
                        foreach ($searchFields as $field) {
                            $query->orWhere($field, 'like', '%' . $searchData . '%');
                        }
                    });

                    $result = $query->offset(($offset - 1) * $limit)
                        ->limit($limit)
                        ->get();
                    $count = $query->paginate($limit)->total();
                } elseif (empty($searchData)) {
                    $result = $query->offset(($offset - 1) * $limit)
                        ->limit($limit)
                        ->get();
                    $count = $query->paginate($limit)->total();
                }
                break;

            default:
                $result = $query->get();
                $count = $query->paginate($limit)->total();
                break;
        }

        if ($result->isEmpty()) {
            throw new \RuntimeException('No records found.');
        }

        return ['result' => $result, 'count' => $count];
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
