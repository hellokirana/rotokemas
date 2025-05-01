<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $news = News::where('audience', 'all')
            ->orWhere('audience', $user->type)
            ->latest()
            ->get();

        $is_admin = $user->role === 'superadmin';

        return view('data.news.index', compact('news', 'is_admin'));
    }

    public function create()
    {
        return view('data.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
            'link' => 'nullable|url',
            'image' => 'nullable|image',
            'document' => 'nullable|file',
            'audience' => 'required|in:all,founder,member,partner',
        ]);

        $news = new News();
        $news->title = $request->title;
        $news->content = $request->content;
        $news->slug = Str::slug($request->title . '-' . Str::random(6));
        $news->link = $request->link;
        $news->audience = $request->audience;

        if ($request->hasFile('image')) {
            $news->image_path = $request->file('image')->store('uploads/news/images', 'public');
        }

        if ($request->hasFile('document')) {
            $news->document_path = $request->file('document')->store('uploads/news/documents', 'public');
        }

        $news->save();

        return redirect()->route('news.index')->with('success', 'News created successfully.');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('data.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
            'link' => 'nullable|url',
            'image' => 'nullable|image',
            'document' => 'nullable|file',
            'audience' => 'required|in:all,founder,member,partner',
        ]);

        $news->title = $request->title;
        $news->content = $request->content;
        $news->link = $request->link;
        $news->audience = $request->audience;

        if ($request->hasFile('image')) {
            $news->image_path = $request->file('image')->store('uploads/news/images', 'public');
        }

        if ($request->hasFile('document')) {
            $news->document_path = $request->file('document')->store('uploads/news/documents', 'public');
        }

        $news->save();

        return redirect()->route('news.index')->with('success', 'News updated successfully.');
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        return view('data.news.show', compact('news'));
    }



    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return back()->with('success', 'News deleted.');
    }
}
