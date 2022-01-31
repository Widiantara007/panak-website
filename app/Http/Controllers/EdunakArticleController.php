<?php

namespace App\Http\Controllers;

use App\Models\EdunakArticle;
use App\Models\EdunakCategory;
use App\Models\Log;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EdunakArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = EdunakArticle::all();
        return view('admin.edunak.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = EdunakCategory::all();
        return view('admin.edunak.article.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'title' => 'required|string',
            'cover_image' => 'required|image',
            'content' => 'required',
            'tags' => 'required',
            'is_published' => 'required',
        ]);

        // save image
        $fileNameImage = date("Y-m-d-His") . '_' . $request->file('cover_image')->getClientOriginalName();
        $image = $request->file('cover_image')
            ->storeAs('public/images/edunak/articles', $fileNameImage);

        $store = EdunakArticle::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => SlugService::createSlug(EdunakArticle::class, 'slug', $request->title),
            'cover_image' => $fileNameImage,
            'content' => $request->content,
            'tags' => $request->tags,
            'is_published' => $request->is_published,
        ]);

        if ($store) {
            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'edunak',
                'activity' => 'add',
                'description' => 'Add artikel ' . $request->title,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);

            Toastr::success('Artikel berhasil ditambahkan', 'Berhasil!');
            return redirect()->route('edunak-article.index');
        } else {
            Toastr::error('Artikel gagal ditambahkan, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = EdunakCategory::all();
        $article = EdunakArticle::find($id);
        return view('admin.edunak.article.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'title' => 'required|string',
            'cover_image' => 'nullable|image',
            'content' => 'required',
            'tags' => 'required',
            'is_published' => 'required',
        ]);
        $article = EdunakArticle::find($id);

        // Overwrite image
        if ($request->hasFile('cover_image')) {
            $existingImage = $article->image;
            Storage::disk('public')->delete('images/edunak/articles/' . $existingImage);

            $fileNameImage = date("Y-m-d-His") . '_' . $request->file('cover_image')->getClientOriginalName();
            $image = $request->file('cover_image')
                ->storeAs('public/images/edunak/articles', $fileNameImage);

            $image = $article->update([
                'cover_image' => $fileNameImage,
            ]);
        }

        $article->slug = null;
        $update = $article->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => SlugService::createSlug(EdunakArticle::class, 'slug', $request->title),
            'content' => $request->content,
            'tags' => $request->tags,
            'is_published' => $request->is_published,
        ]);

        if ($update) {

            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'edunak',
                'activity' => 'edit',
                'description' => $request->title . ' edited',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);

            Toastr::success('Artikel berhasil diubah', 'Berhasil!');
            return redirect()->route('edunak-article.index');
        } else {
            Toastr::error('Artikel gagal diubah, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = EdunakArticle::find($id);
        $title = $article->title;
        $existingImage = $article->cover_image;
        Storage::delete('public/images/edunak/articles/' . $existingImage);
        $delete = $article->delete();
        if ($delete) {
            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'edunak',
                'activity' => 'delete',
                'description' => $title . ' deleted',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);
            
            Toastr::success('Artikel berhasil dihapus', 'Berhasil!');
            return redirect()->route('edunak-article.index');
        } else {
            Toastr::error('Artikel gagal dihapus, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }
}
