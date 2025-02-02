<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PetugasController extends Controller
{
    public function index() {
        try {
            $guru = Petugas::with('User')->get();
            if ($guru->isEmpty()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'No data found'
                ], 404);
            }
    
            $response = [
                'ok' => true,
                'guru' => $guru->map(function ($data) {
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

    public function store(Request $request) {
        try {
            $request->validate([
                'nama' => 'required|string',
                'password' => 'required|string'
            ]);
    
            $user = User::create([
                'password' => $request->password
            ]);
    
            $data = [
                'nama' => $request->nama,
                'id_user' => $user->id
            ];
    
            Petugas::create($data);
    
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
}
