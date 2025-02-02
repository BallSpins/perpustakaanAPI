<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Murid;
use App\Models\Petugas;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getGuru() {
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
                'guru' => $guru->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'nama' => $item->nama,
                        'status' => $item->status,
                        'id_user' => $item->id_user,
                        'password' => $item->User->password
                    ];
                })
            ];
    
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPetugas() {
        try {
            $petugas = Petugas::with('User')->get();

            if ($petugas->isEmpty()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'No data found'
                ], 404);
            }
    
            $response = [
                'ok' => true,
                'guru' => $petugas->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'nama' => $item->nama,
                        'status' => $item->status,
                        'id_user' => $item->id_user,
                        'password' => $item->User->password
                    ];
                })
            ];
    
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
