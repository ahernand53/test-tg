<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $categories = Category::all();

        if ($categories->count() === 0) {

        }

        return $this->showAll($categories);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|unique:categories'
        ];

        $this->validate($request, $rules);

        $category = Category::create($request);

        return $this->showOne($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return JsonResponse
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => [
                'string',
                Rule::unique('categories')->ignoreModel($category)
            ]
        ];

        $this->validate($request, $rules);

        if ($request->has('name')) {
            $category->name = $request->get('name');
            $category->save();
        }

        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->showOne($category, 200);
    }
}
