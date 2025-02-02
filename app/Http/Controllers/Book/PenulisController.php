<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Penulis;
use Illuminate\Http\Request;

class PenulisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $penulis = Penulis::all();

            if ($penulis->isEmpty()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'No data found'
                ], 404);
            }

            $response = [
                'ok' => true,
                'penulis' => $penulis->map(function ($data) {
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

            Penulis::create($request->all());

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
            $penulis = Penulis::find($id);

            if (!$penulis) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            return response()->json([
                'ok' => true,
                'penulis' => $penulis
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
            $penulis = Penulis::find($id);
            
            if (!$penulis) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            $request->validate([
                'nama' => 'required|string'
            ]);

            $penulis->update($request->all());

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
            $penulis = Penulis::find($id);
            
            if (!$penulis) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            $penulis->delete();
            
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
