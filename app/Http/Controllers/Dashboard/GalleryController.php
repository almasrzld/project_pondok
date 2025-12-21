<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GalleryController extends Controller
{
    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);
        return view('pages.dashboard.gallery.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'image'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'category' => 'nullable|string|max:100',
        ]);

        $image    = $request->file('image');
        $filename = uniqid() . '.jpg';
        $path     = "gallery/{$filename}";

        $img = $this->imageManager
            ->read($image)
            ->cover(1200, 900)
            ->toJpeg(80);

        Storage::disk('public')->put($path, $img);

        Gallery::create([
            'title'    => $request->title,
            'image'    => $path,
            'category' => $request->category,
        ]);

        toastr()->success('Foto galeri berhasil ditambahkan');

        return back();
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image);

            $image    = $request->file('image');
            $filename = uniqid() . '.jpg';
            $path     = "gallery/{$filename}";

            $img = $this->imageManager
                ->read($image)
                ->cover(1200, 900)
                ->toJpeg(80);

            Storage::disk('public')->put($path, $img);

            $data['image'] = $path;
        }

        $gallery->update($data);

        toastr()->success('Foto galeri berhasil diubah');

        return back();
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        toastr()->success('Foto galeri berhasil dihapus');

        return back();
    }
}
