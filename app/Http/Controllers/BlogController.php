<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class BlogController
 *
 * @package App\Http\Controllers
 */
class BlogController extends Controller
{
    /**
     * Display a listing of the blog posts.
     *
     * @return View
     */
    public function index(): View
    {
        $companyName = Auth::user()->company_name;
        $posts = BlogPost::where('company_name', $companyName)->paginate(10);
        return view('blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new blog post.
     *
     * @return View
     */
    public function create(): View
    {
        return view('blog.create');
    }

    /**
     * Store a newly created blog post in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $companyOwner = Auth::user();

        BlogPost::create([
            'title' => $request->title,
            'content' => $request->content,
            'author_id' => $companyOwner->id,
            'company_name' => $companyOwner->company_name,
        ]);

        return redirect()->route('blog.index')->with('success', 'Blog post created successfully.');
    }

    /**
     * Display the specified blog post.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $companyName = Auth::user()->company_name;
        $post = BlogPost::where('id', $id)->where('company_name', $companyName)->firstOrFail();
        return view('blog.show', compact('post'));
    }

    /**
     * Show the form for editing the specified blog post.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $companyName = Auth::user()->company_name;
        $post = BlogPost::where('id', $id)->where('company_name', $companyName)->firstOrFail();
        return view('blog.edit', compact('post'));
    }

    /**
     * Update the specified blog post in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $companyName = Auth::user()->company_name;
        $post = BlogPost::where('id', $id)->where('company_name', $companyName)->firstOrFail();
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('blog.index')->with('success', 'Blog post updated successfully.');
    }

    /**
     * Remove the specified blog post from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $companyName = Auth::user()->company_name;
        $post = BlogPost::where('id', $id)->where('company_name', $companyName)->firstOrFail();
        $post->delete();

        return redirect()->route('blog.index')->with('success', 'Blog post deleted successfully.');
    }
}
