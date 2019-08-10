<?php

use App\Article;
use App\Category;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        Article::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $USERS_QUANTITY         = 10;
        $CATEGORIES_QUANTITY    = 10;
        $ARTICLES_PER_CATEGORY  = 10;

        factory(User::class, $USERS_QUANTITY)->create();
        factory(Category::class, $CATEGORIES_QUANTITY)->create()
            ->each(function (Category $category) use ($ARTICLES_PER_CATEGORY) {
                for ($i = 0; $i < $ARTICLES_PER_CATEGORY; $i++) {
                    $category->articles()->save(factory(Article::class)->make());
                }
            });


    }
}
