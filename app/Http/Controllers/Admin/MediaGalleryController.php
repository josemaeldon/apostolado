<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mediaItems = MediaGallery::latest()->paginate(10);
        return view('admin.media-gallery.index', compact('mediaItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.media-gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video',
            'file_path' => 'nullable|file|max:51200', // 50MB max
            'url' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('media-gallery');
        }
        
        // Normalize YouTube URL if provided
        if (!empty($validated['url']) && $validated['type'] === 'video') {
            $validated['url'] = $this->normalizeYoutubeUrl($validated['url']);
        }

        MediaGallery::create($validated);

        return redirect()->route('admin.media-gallery.index')
            ->with('success', 'Item de mídia criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MediaGallery $mediaGallery)
    {
        return view('admin.media-gallery.show', compact('mediaGallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MediaGallery $mediaGallery)
    {
        return view('admin.media-gallery.edit', compact('mediaGallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MediaGallery $mediaGallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video',
            'file_path' => 'nullable|file|max:51200', // 50MB max
            'url' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('file_path')) {
            if ($mediaGallery->file_path) {
                Storage::delete($mediaGallery->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('media-gallery');
        }
        
        // Normalize YouTube URL if provided
        if (!empty($validated['url']) && $validated['type'] === 'video') {
            $validated['url'] = $this->normalizeYoutubeUrl($validated['url']);
        }

        $mediaGallery->update($validated);

        return redirect()->route('admin.media-gallery.index')
            ->with('success', 'Item de mídia atualizado com sucesso!');
    }

    /**
     * Normalize YouTube URL to standard format
     */
    private function normalizeYoutubeUrl($url)
    {
        // If it's already in the correct format, return as is
        if (empty($url)) {
            return $url;
        }
        
        // Extract video ID from various YouTube URL formats
        $videoId = null;
        
        // Standard watch URL: https://www.youtube.com/watch?v=VIDEO_ID
        if (preg_match('/[?&]v=([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Short URL: https://youtu.be/VIDEO_ID
        elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Embed URL: https://www.youtube.com/embed/VIDEO_ID
        elseif (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }
        
        // If we found a video ID, return standard watch URL
        if ($videoId) {
            return 'https://www.youtube.com/watch?v=' . $videoId;
        }
        
        // Return original URL if not a YouTube URL
        return $url;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MediaGallery $mediaGallery)
    {
        if ($mediaGallery->file_path) {
            Storage::delete($mediaGallery->file_path);
        }
        
        $mediaGallery->delete();

        return redirect()->route('admin.media-gallery.index')
            ->with('success', 'Item de mídia excluído com sucesso!');
    }
}
