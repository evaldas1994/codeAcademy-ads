<?php


namespace App\Service;


use App\Models\Category;
use App\Rules\CategoryParent;

class CategoryManager
{
 public function create($request): Category
 {
     $request->validate([
         'parent_id' => ['required', new CategoryParent],
         'is_active' => ['required', 'boolean'],
         'name' => ['required', 'min:3', 'max:4']
     ]);

     $newCategory = Category::create([
         'name' => $request->name,
         'is_active' => $request->is_active,
         'parent_id' => $request->parent_id,
         'path' => '1/2',
         'is_root' => false
     ]);

     $parentCategoryPath = Category::find($request->parent_id);


     $newCategoryPath = $parentCategoryPath . '/' . $newCategory->id;
     $newCategory->path = $newCategoryPath;
     $newCategory->update();

     return $newCategory;
 }
}
