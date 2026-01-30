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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'published_date' => 'nullable|date',
            'image' => 'nullable|string|max:255',
        ]);

        $validated['author_id'] = auth()->id();
        $validated['published_date'] = $validated['published_date'] ?? now();

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
            'image' => 'nullable|string|max:255',
        ]);

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
