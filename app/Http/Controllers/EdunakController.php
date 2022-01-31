<?php

namespace App\Http\Controllers;

use App\Models\EdunakArticle;
use App\Models\EdunakCategory;
use Illuminate\Http\Request;

class EdunakController extends Controller
{
    public function index(Request $request)
    {
        $page_size = 5;
        $categories = EdunakCategory::all();
        if(isset($request->category)){
            $category_id = EdunakCategory::where('category', $request->category)->first()->id;
            $articles = EdunakArticle::where('is_published', true)->where('category_id', $category_id)->paginate($page_size);
        }elseif(isset($request->tag)){
            $articles = EdunakArticle::where('is_published', true)->where('tags', 'LIKE', '%'.$request->tag.'%')->paginate($page_size);
        }else{
            $articles = EdunakArticle::where('is_published', true)->paginate($page_size);

        }
        return view('edunak.index', compact('categories','articles'));
    }

    public function show($slug){
        $article = EdunakArticle::where('slug', $slug)->where('is_published', true)->first();
        if(empty($article)){
            return abort(404);
        }
        return view('edunak.show', compact('article'));
    }
}
