<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ProductModel;

class Products extends ResourceController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        return $data ? $this->respond($data) : $this->failNotFound("Product not found");
    }

    public function create()
    {
        $data = $this->request->getJSON(true); // ✅ يستخدم JSON
    
        if (!$this->model->insert($data)) {
            return $this->failValidationErrors($this->model->errors());
        }
    
        return $this->respondCreated($data);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        if (!$this->model->update($id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound('Product not found');
        }

        $this->model->delete($id);
        return $this->respondDeleted(['id' => $id]);
    }
    
}
