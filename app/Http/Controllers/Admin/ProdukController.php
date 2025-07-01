<?php

namespace App\Http\Controllers\Admin;

use Log;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
    
    public function index(){
        $produk = Product::all();
        return view('admin.crud-produk', [
            'title' => 'List Produk',
            'products' => $produk,
        ]);
    }

    public function store(Request $request)
    {
        
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('foto'), $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => 'foto/' . $imageName,
                ]);
            }
        }

        session()->flash('success', 'Produk berhasil ditambahkan!');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $produk = Product::findOrFail($id);

        // Update data utama
        $produk->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        // Hapus gambar jika diminta
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imgId) {
                $img = ProductImage::find($imgId);
                if ($img) {
                    // Hapus file fisik dari public/foto/
                    $filePath = public_path($img->image_url);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $img->delete();
                }
            }
        }

        // Simpan gambar baru
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('foto'), $imageName);

                ProductImage::create([
                    'product_id' => $produk->id,
                    'image_url' => 'foto/' . $imageName,
                ]);
            }
        }

        session()->flash('success', 'Produk berhasil diperbarui!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $produk = Product::findOrFail($id);
        $produk->delete();

        session()->flash('success', 'Activity has been removed');
        return redirect()->back();

    }

}
