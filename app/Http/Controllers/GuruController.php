<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    private $status = ['aktif', 'non aktif'];
    
    public function index() {
        try {
            $guru = Guru::with('User')->get();
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

    public function show($id) {
        try {
            $guru = Guru::with('User')->find($id);

            if (!$guru) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            return response()->json([
                'ok' => true,
                'murid' => $guru
            ], 200);

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
                'status' => ['required', Rule::in($this->status)],
                'password' => 'required|string'
            ]);
    
            $user = User::create([
                'password' => $request->password
            ]);
    
            $data = [
                'nama' => $request->nama,
                'status' => $request->status,
                'id_user' => $user->id
            ];
    
            Guru::create($data);
    
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

    public function update(Request $request, $id) {
        try {
            $request->validate([
                'nama' => 'required|string',
                'status' => ['required', Rule::in($this->status)],
                'password' => 'required|string'
            ]);

            $guru = Guru::with('User')->find($id);

            if (!$guru) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            $guru->update($request->all());

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
    
    public function destroy($id) {
        try {
            $guru = Guru::with('User')->find($id);
            
            if (!$guru) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            $user = User::find($guru->id_user);

            $user->delete();
            $guru->delete();

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
