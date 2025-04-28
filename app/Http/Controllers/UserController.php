<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\DataTables\UserDataTable;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function show($id, $name)
    {
        return view('user', compact('id', 'name'));
    }

    public function index(UserDataTable $dataTable)
    {
        $level_id = LevelModel::all(); // Sesuaikan dengan model level Anda
        return $dataTable->render('user.index', compact('level_id'));
    }

    public function countByLevel()
    {
        // Mengambil jumlah user dikelompokkan berdasarkan level_id dengan nama level
        $userCounts = UserModel::join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
            ->selectRaw('m_user.level_id, m_level.level_nama, count(*) as total')
            ->groupBy('m_user.level_id', 'm_level.level_nama')
            ->get();

        return view('user.user_count', compact('userCounts'));
    }

    public function tambah()
    {
        return view('user.user_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user');
    }

    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user.user_ubah', ['data' => $user]);
    }

    public function ubah_simpan(Request $request, $id)
    {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->level_id = $request->level_id;
        $user->save();
        return redirect('/user');
    }

    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $query = UserModel::with('level');

            if ($request->level_id) {
                $query->where('level_id', $request->level_id);
            }

            return DataTables::of($query)
                ->addColumn('level_nama', function ($user) {
                    return $user->level ? $user->level->level_nama : '-'; // Pastikan mengakses properti level_nama
                })
                ->addColumn('id', function ($user) {
                    return $user->user_id;
                })
                ->addColumn('aksi', function ($row) {
                    $detailUrl = route('user.detail_ajax', $row->user_id);
                    $editUrl = route('user.edit_ajax', $row->user_id);
                    $deleteUrl = route('user.confirm_ajax', $row->user_id);

                    return '
                        <div class="d-flex justify-content-center gap-2" style="white-space: nowrap;">
                            <button onclick="modalAction(\'' . $detailUrl . '\')" class="btn btn-sm btn-info" style="margin-left: 5px;">
                                <i class="fas fa-info-circle"></i> Detail
                            </button>
                            <button onclick="modalAction(\'' . $editUrl . '\')" class="btn btn-sm btn-primary" style="margin-left: 5px;">
                                <i class="fas fa-edit"></i> Ubah
                            </button>
                            <button onclick="modalAction(\'' . $deleteUrl . '\')" class="btn btn-sm btn-danger" style="margin-left: 5px;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['level_nama', 'aksi']) // Pastikan kolom bisa di-render sebagai teks
                ->make(true);
        }
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')
            ->with('level', $level);
    }

    public function store_ajax(Request $request)
    {
        Log::info('store_ajax called', $request->all());

        // Cek apakah request berupa AJAX atau ingin JSON response
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:6'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                Log::warning('Validation failed in store_ajax', $validator->errors()->toArray());
                return response()->json([
                    'status' => false, // response status: false = gagal, true = berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            try {
                // Simpan user dengan hashing password untuk keamanan
                UserModel::create([
                    'level_id' => $request->level_id,
                    'username' => $request->username,
                    'nama' => $request->nama,
                    'password' => bcrypt($request->password) // Enkripsi password
                ]);
            } catch (\Exception $e) {
                Log::error('Exception in store_ajax: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data.'
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }

        Log::warning('Invalid request in store_ajax');
        return response()->json([
            'status' => false,
            'message' => 'Request tidak valid'
        ], 400);
    }

    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, string $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:6|max:20'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,    // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()  // menunjukkan field mana yang error
                ]);
            }

            $check = UserModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $user = UserModel::find($id);
        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, string $id)
    {
        $user = UserModel::find($id);
        $user->delete();
        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function detail_ajax($id)
    {
        $user = UserModel::with('level')->findOrFail($id);
        return view('user.detail_ajax', compact('user'));
    }
}
