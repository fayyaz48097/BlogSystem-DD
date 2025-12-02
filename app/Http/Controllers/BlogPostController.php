<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{

    private function generateImageName($extension)
    {
        $number = 1;
        do {
            $filename = "blogimage{$number}.{$extension}";
            $number++;
        } while (Storage::disk('public')->exists('blog_images/' . $filename));

        return 'blog_images/' . $filename;
    }

    //  Now passing BOTH posts and categories
    public function index()
    {
        $posts = BlogPost::with('category')->latest()->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('blog_posts.index', compact('posts', 'categories'));
    }

    //  Pass categories to create form
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('blog_posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'main_title'       => 'required|string|max:255',
            'secondary_title'  => 'nullable|string|max:255',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
            'content'          => 'required',
            'hashtags'         => 'nullable|string',
            'category_id'      => 'nullable|exists:categories,id', // ← added this
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $path = $this->generateImageName($extension);
            $file->storeAs('', $path, 'public');
            $data['image'] = $path;
        }

        if ($request->filled('hashtags')) {
            $tags = array_filter(array_map('trim', explode(',', $request->hashtags)));
            $data['hashtags'] = $tags;
        } else {
            $data['hashtags'] = null;
        }

        BlogPost::create($data);

        return redirect()->route('blog-posts.index')->with('success', 'Post created successfully!');
    }

    public function show(BlogPost $blogPost)
    {
        return view('blog_posts.show', compact('blogPost'));
    }

    public function edit(BlogPost $blogPost)
    {
        $categories = Category::orderBy('name')->get();
        return view('blog_posts.edit', compact('blogPost', 'categories'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $request->validate([
            'main_title'       => 'required|string|max:255',
            'secondary_title'  => 'nullable|string|max:255',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
            'content'          => 'required',
            'hashtags'         => 'nullable|string',
            'category_id'      => 'nullable|exists:categories,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($blogPost->image && Storage::disk('public')->exists($blogPost->image)) {
                Storage::disk('public')->delete($blogPost->image);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $path = $this->generateImageName($extension);
            $file->storeAs('', $path, 'public');
            $data['image'] = $path;
        }

        if ($request->filled('hashtags')) {
            $tags = array_filter(array_map('trim', explode(',', $request->hashtags)));
            $data['hashtags'] = $tags;
        } else {
            $data['hashtags'] = null;
        }

        $blogPost->update($data);

        return redirect()->route('blog-posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->image && Storage::disk('public')->exists($blogPost->image)) {
            Storage::disk('public')->delete($blogPost->image);
        }
        $blogPost->delete();

        return redirect()->route('blog-posts.index')->with('success', 'Post deleted successfully!');
    }
}
