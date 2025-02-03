<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $kategori = Kategori::all();
            
            if ($kategori->isEmpty()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'No data found'
                ], 404);
            }

            $response = [
                'ok' => true,
                'kategori' => $kategori->map(function ($data) {
                    return $data;
                })
            ];
    
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ], 500);
        }  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string'
            ]);

            Kategori::create($request->all());

            return response()->json([
                'ok' => true,
                'message' => 'Data inserted successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $kategori = Kategori::find($id);

            if (!$kategori) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            return response()->json([
                'ok' => true,
                'kategori' => $kategori
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $kategori = Kategori::find($id);
            
            if (!$kategori) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            $request->validate([
                'nama' => 'required|string'
            ]);

            $kategori->update($request->all());

            return response()->json([
                'ok' => true,
                'message' => 'Data updated successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kategori = Kategori::find($id);
            $kategoribuku = KategoriBuku::where('id_kategori', $id);
            
            if (!$kategori) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            optional($kategoribuku->delete());

            $kategori->delete();
            
            return response()->json([
                'ok' => true,
                'message' => 'Data deleted successfully'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
