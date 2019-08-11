<?php

namespace App\Http\Controllers\Category;

use App\Article;
use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class CategoryArticleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Category $category
     * @return void
     */
    public function index(Category $category)
    {
        $articles = $category->articles;

        return $this->showAll($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Category $category
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Category $category, Request $request)
    {
        $rules = [
          'name' => 'required|string',
          'register_number' => 'required|min:36|unique:articles',
          'quantity' => 'required|numeric'
        ];

        $this->validate($request, $rules);

        $category = $category->articles()->save(
            new Article([
                'name' => $request->get('name'),
                'register_number' => $request->get('register_number'),
                'quantity' => $request->get('quantity')
            ])
        );

        return $this->showOne($category, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category
     * @param \App\Article $article
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Category $category, Article $article)
    {
        $rules = [
          'name' => 'string',
          'quantity' => 'numeric'
        ];

        $this->validate($request, $rules);

        $category->articles()->save($article);

        if ($request->has('name')) {
            $article->name = $request->get('name');
            $category->articles()->save($article);
        }

        if ($request->has('quantity')) {
            $article->quantity = $request->get('quantity');
            $category->articles()->save($article);
        }

        return $this->showOne($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Article $article
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return $this->showOne($article);
    }
}
