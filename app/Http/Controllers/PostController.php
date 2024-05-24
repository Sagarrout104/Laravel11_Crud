<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $allPost = Cache::remember("post", "30", function () {
        //     return Post::all();
        // });
        $allPost = Post::paginate(2);
        return view("index", compact("allPost"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view("create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "image" => ["required", "image", "mimes:png,jpg", "max:200"],
            "title" => ["required", "max:225"],
            "category_id" => ["required", "integer"],
            "description" => ["required"],
        ]);

        if ($request->hasFile('image')) {
            $fileName = time() . "." . $request->image->getClientOriginalExtension();
            $filePath = $request->image->storeAs("uploads", $fileName);
        }


        Post::create([
            "image" => 'storage/' . $filePath,
            "title" => $request->title,
            "category_id" => $request->category_id,
            "description" => $request->description
        ]);

        return redirect()->route("post.index")->with("success", "Data created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view("show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $post = Post::find($id);
        return view("edit", compact("post", "categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate common fields
        $request->validate([
            "title" => ["required", "max:255"],
            "category_id" => ["required", "integer"],
            "description" => ["required"],
        ]);

        // Find the post
        $post = Post::findOrFail($id);

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Validate the image
            $request->validate([
                "image" => ["image", "mimes:png,jpg,jpeg", "max:2048"], // Adjusted max size
            ]);

            // Store the new image
            $fileName = time() . '.' . $request->image->getClientOriginalExtension();
            $filePath = $request->image->storeAs('uploads', $fileName);

            // Delete the old image if it exists
            if ($post->image) {
                $oldImagePath = public_path($post->image); // Convert the storage path to a public path
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // Update the post image path
            $post->image = 'storage/' . $filePath;
        }

        // Update the post fields
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->description = $request->description;

        // Save the updated post
        $post->save();

        // Redirect to the post index with a success message
        return redirect()->route('post.index')->with('success', 'Data updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('post.index')->with('success', 'Deleted successfully');
    }

    public function trash()
    {

        $allTrash = Post::onlyTrashed()->get();
        return view('trash', compact('allTrash'));
    }
    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->route('post.index')->with('success', 'Restore successfully');
    }
    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->forceDelete();
        File::delete($post->image);
        return redirect()->route('post.index')->with('success', 'Permanent Delete');
    }
}
