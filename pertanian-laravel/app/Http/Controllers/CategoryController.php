<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_categories' => 'required|string|max:100',
            'price'           => 'required|numeric',
            'description'     => 'required',
            'photo'           => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $nama_file = null;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_categories'), $nama_file);
        }

        Category::create([
            'nama_categories' => $request->nama_categories,
            'price'           => $request->price,
            'description'     => $request->description,
            'photo'           => $nama_file,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama_categories' => 'required|string|max:100',
            'price'           => 'required|numeric',
            'description'     => 'required',
            'photo'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nama_categories', 'price', 'description']);

        if ($request->hasFile('photo')) {

            if ($category->photo && file_exists(public_path('img_categories/' . $category->photo))) {
                unlink(public_path('img_categories/' . $category->photo));
            }

            $file = $request->file('photo');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_categories'), $nama_file);

            $data['photo'] = $nama_file;
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Category $category)
    {
        DB::table('tb_transaction')->where('id_kategori', $category->id)->delete();

        if ($category->photo && file_exists(public_path('img_categories/' . $category->photo))) {
            unlink(public_path('img_categories/' . $category->photo));
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }

    public function generatePDF()
{
    // Tambah batas waktu & memori agar Dompdf tidak hang
    set_time_limit(300);
    ini_set('memory_limit', '512M');

    $categories = Category::all();

    // Konfigurasi Dompdf agar bisa membaca file:// dan UTF-8
    $pdf = \PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'DejaVu Sans',
            'dpi' => 96
        ])
        ->loadView('categories.pdf', compact('categories'))
        ->setPaper('a4', 'landscape');

    return $pdf->stream('Laporan_Kategori_' . date('d-m-Y') . '.pdf');
}

}
