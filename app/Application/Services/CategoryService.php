<?php

namespace App\Application\Services;

use App\Application\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(
        readonly CategoryRepository $repo
    )
    {    
    }

    public function getAllCategories()
    {
        return $this->repo->query()->get();
    }

    public function getCategoryById(int $id)
    {
        return $this->repo->findById($id);
    }

    public function createCategory(array $data)
    {
        return $this->repo->create($data);
    }

    public function updateCategory(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deleteCategory(int $id)
    {
        $this->repo->delete($id);
    }
}
