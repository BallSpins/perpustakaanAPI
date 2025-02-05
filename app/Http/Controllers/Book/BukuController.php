<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\KategoriBuku;
use App\Models\Penerbit;
use App\Models\Penulis;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $buku = Buku::with(['KategoriBuku', 'Penulis', 'Penerbit'])->get();

            if (!$buku) {
                return response()->json([
                    'ok' => false,
                    'message' => 'No data found'
                ], 404);
            }

            $response = [
                'ok' => true,
                'buku' => $buku->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'judul' => $data->judul,
                        'id_penerbit' => $data->id_penerbit,
                        'tgl_terbit' => $data->tgl_terbit,
                        'id_penulis' => $data->id_penulis,
                        'stock' => $data->stock,
                        'kategori_buku' => $data->KategoriBuku->map(function ($kb) {
                            return [
                                "id" => $kb->id,
                                "id_buku" => $kb->id_buku,
                                "id_kategori" => $kb->id_kategori,
                                "nama" => Kategori::where('id', $kb->id_kategori)->pluck('nama')
                            ];
                        }),
                        'penulis' => $data->Penulis,
                        'penerbit' => $data->Penerbit
                    ];
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
                'judul' => 'required|string',
                'id_kategori' => 'required|integer',
                'id_penerbit'=> 'required|integer',
                'tgl_terbit' => 'required|date',
                'id_penulis' => 'required|integer',
                'stock' => 'required|integer'
            ]);

            $error = ['errors' => []];

            $penerbit = Penerbit::find($request->id_penerbit);
            $penulis = Penulis::find($request->id_penulis);
            $kategori = Kategori::find($request->id_kategori);

            if (!$penerbit || !$penulis || !$kategori) {
                if (!$penerbit) {
                    $error['errors']['penerbit'] = 'Data with id '. $request->id_penerbit . ' doesn\'t exist';
                }
                if (!$penulis) {
                    $error['errors']['penulis'] = 'Data with id '. $request->id_penulis . ' doesn\'t exist';
                }
                if (!$kategori) {
                    $error['errors']['kategori'] = 'Data with id '. $request->id_kategori . ' doesn\'t exist';
                }

                return response()->json([
                    'ok' => false,
                    'message' => 'Failed to insert data',
                    $error
                ], 404);
            }

            $dataBuku = [
                'judul' => $request->judul,
                'id_penerbit'=> $request->id_penerbit,
                'tgl_terbit' => $request->tgl_terbit,
                'id_penulis' => $request->id_penulis,
                'stock' => $request->stock
            ];

            $buku = Buku::create($dataBuku);
            
            $dataKategoriBuku = [
                'id_buku' => $buku->id,
                'id_kategori' => $request->id_kategori
            ];

            KategoriBuku::create($dataKategoriBuku);

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
            $buku = Buku::with(['KategoriBuku', 'Penulis', 'Penerbit'])->find($id);

            if (!$buku) {
                return response()->json([
                    'ok' => false,
                    'message' => 'No data found'
                ], 404);
            }
    
            return response()->json([
                'ok' => true,
                'buku' => [
                        'id' => $buku->id,
                        'judul' => $buku->judul,
                        'id_penerbit' => $buku->id_penerbit,
                        'tgl_terbit' => $buku->tgl_terbit,
                        'id_penulis' => $buku->id_penulis,
                        'stock' => $buku->stock,
                        'kategori_buku' => $buku->KategoriBuku->map(function ($kb) {
                            return [
                                "id" => $kb->id,
                                "id_buku" => $kb->id_buku,
                                "id_kategori" => $kb->id_kategori,
                                "nama" => Kategori::where('id', $kb->id_kategori)->pluck('nama')
                            ];
                        }),
                        'penulis' => $buku->Penulis,
                        'penerbit' => $buku->Penerbit
                    ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ], 500);
        }
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'judul' => 'required|string',
                'id_kategori' => 'required|integer',
                'id_penerbit'=> 'required|integer',
                'tgl_terbit' => 'required|date',
                'id_penulis' => 'required|integer',
                'stock' => 'required|integer'
            ]);

            $error = ['errors' => []];

            $penerbit = Penerbit::find($request->id_penerbit);
            $penulis = Penulis::find($request->id_penulis);
            $kategori = Kategori::find($request->id_kategori);

            if (!$penerbit || !$penulis || !$kategori) {
                if (!$penerbit) {
                    $error['errors']['penerbit'] = 'Data with id '. $request->id_penerbit . ' doesn\'t exist';
                }
                if (!$penulis) {
                    $error['errors']['penulis'] = 'Data with id '. $request->id_penulis . ' doesn\'t exist';
                }
                if (!$kategori) {
                    $error['errors']['kategori'] = 'Data with id '. $request->id_kategori . ' doesn\'t exist';
                }

                return response()->json([
                    'ok' => false,
                    'message' => 'Failed to insert data',
                    $error
                ], 404);
            }

            $buku = Buku::with(['KategoriBuku', 'Penulis', 'Penerbit'])->find($id);

            if (!$buku) {
                return response()->json([
                    'ok' => false,
                    'message' => 'No data found'
                ], 404);
            }

            $dataBuku = [
                'judul' => $request->judul,
                'id_penerbit'=> $request->id_penerbit,
                'tgl_terbit' => $request->tgl_terbit,
                'id_penulis' => $request->id_penulis,
                'stock' => $request->stock
            ];

            $buku->update($dataBuku);
            
            $dataKategoriBuku = [
                'id_buku' => $buku->id,
                'id_kategori' => $request->id_kategori
            ];

            $KategoriBuku = KategoriBuku::where('id_buku', $buku->id)->first();

            if ($KategoriBuku) {
                $KategoriBuku->update($dataKategoriBuku);
            } else {
                KategoriBuku::create($dataKategoriBuku);
            }

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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $buku = Buku::with(['KategoriBuku', 'Penulis', 'Penerbit'])->find($id);

            if (!$buku) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Data with id '. $id . ' doesn\'t exist'
                ], 404);
            }

            $KategoriBuku = KategoriBuku::find($id);
            if($KategoriBuku) {
                $KategoriBuku->delete();
            }

            $buku->delete();

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
