@extends('layouts.app')

@section('title', 'Categories | Pertanian Admin')

@section('content')
<div class="container-fluid py-4">
    <h3 class="mb-4 fw-bold">Daftar Kategori Produk</h3>

    <a href="{{ route('categories.create') }}" class="btn btn-success mb-4 fw-bold">
        + Tambah Data
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm">
            <thead class="table-success text-dark fw-bold">
                <tr>
                    <th style="width:30%">Photo</th>
                    <th>Categories</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="text-center">
                       <img src="{{ asset('img_categories/' . $category->photo) }}"
                            style="width:380px; height:240px; object-fit:cover; border-radius:20px; box-shadow:0 10px 30px rgba(0,0,0,0.2);"
                            onerror="this.src='https://via.placeholder.com/380x240?text=No+Image';">
                    </td>
                    <td class="fw-bold fs-5">{{ $category->nama_categories }}</td>
                    <td class="text-success fw-bold">Rp {{ number_format($category->price) }}</td>
                    <td>{{ $category->description ?? '-' }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection