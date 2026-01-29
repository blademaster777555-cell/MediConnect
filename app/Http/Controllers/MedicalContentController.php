<?php

namespace App\Http\Controllers;

use App\Models\MedicalContent;
use Illuminate\Http\Request;

class MedicalContentController extends Controller
{
    /**
     * Display a listing of medical content
     */
    public function index(Request $request)
    {
        $query = MedicalContent::with('author');
        
        if ($request->has('category')) {
            $query->where('category', $request->query('category'));
        }
        
        $contents = $query->paginate(10);
        return view('medical-content.index', compact('contents'));
    }

    /**
     * Show the form for creating new medical content
     */
    public function create()
    {
        return view('medical-content.create');
    }

    /**
     * Store a newly created medical content
     */
    /**
     * Store a newly created medical content
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'published_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['author_id'] = auth()->id();
        $validated['published_date'] = $validated['published_date'] ?? now();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('medical-content', 'public');
            // Check if we need to prepend 'storage/' or if the view uses asset('storage/...')
            // Existing code in news.blade.php uses $article['image'] directly.
            // If previous data was full URL, we should probably standardize.
            // For now, let's store the full asset URL or relative path. 
            // Most Laravel apps store relative path and use asset('storage/' . $path).
            // BUT, the existing seeders might have 'http...' URLs.
            // Let's store the relative path, and in the View, check if it starts with http.
            // Actually, to be consistent with existing views that might expect full URL if previous data was manual URL:
            // "https://via.placeholder.com..."
            // I will store the relative path 'medical-content/filename.jpg'.
            // The Views will need to be robust: if (Str::startsWith($image, 'http')) -> use as is, else -> asset('storage/'.$image).
            $validated['image'] = 'storage/' . $path; // Storing with 'storage/' prefix to make it easier, OR just the path.
            // Let's look at doctor-profile image logic. It uses asset('storage/' . $user->image).
            // So if I save 'medical-content/xyz.jpg', I need to use asset('storage/'...) in view.
            // BUT, if I save 'storage/medical-content/xyz.jpg', I can just use asset().
            // Wait, existing seeders put full URLs. if I just save relative path, existing views might break if they don't use asset().
            // Let's check news.blade.php: <img src="{{ $article['image'] ... }}">. It assumes the DB content IS the Source.
            // So I should generate the full URL or at least the path starting with /storage/.
            $validated['image'] = asset('storage/' . $path);
        }

        MedicalContent::create($validated);

        return redirect()->route('medical-content.index')
            ->with('success', 'Medical content created successfully.');
    }

    /**
     * Display the specified medical content
     */
    public function show(MedicalContent $medicalContent)
    {
        $related = MedicalContent::where('category', $medicalContent->category)
            ->where('id', '!=', $medicalContent->id)
            ->limit(5)
            ->get();

        return view('medical-content.show', [
            'post' => $medicalContent,
            'related' => $related
        ]);
    }

    /**
     * Show the form for editing the specified medical content
     */
    public function edit(MedicalContent $medicalContent)
    {
        return view('medical-content.edit', compact('medicalContent'));
    }

    /**
     * Update the specified medical content
     */
    public function update(Request $request, MedicalContent $medicalContent)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'published_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('medical-content', 'public');
            $validated['image'] = asset('storage/' . $path);
        } else {
            // Keep old image if no new one uploaded
            unset($validated['image']);
        }

        $medicalContent->update($validated);

        return redirect()->route('medical-content.index')
            ->with('success', 'Medical content updated successfully.');
    }

    /**
     * Remove the specified medical content
     */
    public function destroy(MedicalContent $medicalContent)
    {
        $medicalContent->delete();

        return redirect()->route('medical-content.index')
            ->with('success', 'Medical content deleted successfully.');
    }
}
