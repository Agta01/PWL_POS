<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class BarangController extends Controller
{
    public function __invoke(Request $request)
    {
        // remove token
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if ($removeToken) {
            // return response JSON
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',
            ]);
        }
    }
    public function index()
    {
        return BarangModel::all();
    }

    public function store(Request $request)
{
    $rules = [
        'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
        'barang_nama' => 'required|string|max:100',
        'harga_beli' => 'required|integer',
        'harga_jual' => 'required|integer',
        'kategori_id' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $imagePath = $request->file('image')->store('posts', 'public');
    $barang = BarangModel::create([
        'barang_kode' => $request->barang_kode,
        'barang_nama' => $request->barang_nama,
        'harga_beli' => $request->harga_beli,
        'harga_jual' => $request->harga_jual,
        'kategori_id' => $request->kategori_id,
        'image' => $imagePath,
    ]);

    return response()->json($barang, 201);
}

    public function update(Request $request, BarangModel $barang)
    {
        $rules = [
            'barang_kode' => 'required|string|min:3|max:10|unique:m_barang,barang_kode,' . $barang->barang_id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'kategori_id' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists($barang->image)) {
                Storage::disk('public')->delete($barang->image);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
            $barang->image = $imagePath;
        }

        $barang->update($request->except('image'));
        $barang->save();

        return response()->json($barang);
    }


    public function show(BarangModel $barang)
    {
        return BarangModel::find($barang);
    }

    public function destroy(BarangModel $barang)
    {
        $barang->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}