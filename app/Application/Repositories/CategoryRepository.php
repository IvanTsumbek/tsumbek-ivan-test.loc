<?php

namespace App\Application\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function query()
    {
        return Category::query();
    }

    public function findById(int $id)
    {
        return $this->query()->find($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update(int $id, array $data)
    {
        $category = $this->findById($id);

        if (!$category) {
            throw new \Exception('Category not found');
        }

        $category->update($data);

        return $category;
    }

    public function delete(int $id): void
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }
}
