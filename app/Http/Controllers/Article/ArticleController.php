<?php

namespace App\Http\Controllers\Article;

use App\Article;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Response;

class ArticleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $articles = Article::all();

        return $this->showAll($articles);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return Response
     */
    public function show(Article $article)
    {
        return $this->showOne($article);
    }
}
