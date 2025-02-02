<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MuridController extends Controller
{
    private $status = ['aktif', 'non aktif'];

    public function index() {
        try {
            $murid = Murid::with('User')->get();
            if ($murid->isEmpty()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'No data found'
                ], 404);
            }
    
            $response = [
                'ok' => true,
                'murid' => $murid->map(function ($data) {
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
            $murid = Murid::with('User')->find($id);

            if (!$murid) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            return response()->json([
                'ok' => true,
                'murid' => $murid
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
                'kelas' => 'required|string',
                'status' => ['required', Rule::in($this->status)],
                'password' => 'required|string'
            ]);
    
            $user = User::create([
                'password' => $request->password
            ]);
    
            $data = [
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'status' => $request->status,
                'id_user' => $user->id
            ];
    
            Murid::create($data);
    
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
                'kelas' => 'required|string',
                'status' => ['required', Rule::in($this->status)],
                'password' => 'required|string'
            ]);

            $murid = Murid::with('User')->find($id);

            if (!$murid) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            $murid->update($request->all());

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
            $murid = Murid::with('User')->find($id);
            
            if (!$murid) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            $user = User::find($murid->id_user);

            $user->delete();
            $murid->delete();
            
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