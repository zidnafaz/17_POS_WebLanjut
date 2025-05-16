<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }

    public function import()
    {
        return view('kategori.import');
    }

    public function create_ajax()
    {
        return view('kategori.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        Log::info('store_ajax called', $request->all());

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|max:255',
                'kategori_nama' => 'required|string|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                Log::error('Validation failed', $validator->errors()->toArray());
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            try {
                KategoriModel::create([
                    'kategori_kode' => $request->kategori_kode,
                    'kategori_nama' => $request->kategori_nama,
                ]);
            } catch (\Exception $e) {
                Log::error('Exception in store ajax: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan data kategori',
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan'
            ]);
        }

        Log::warning('Invalid request in store_ajax');
        return response()->json([
            'status' => false,
            'message' => 'Request tidak valid'
        ], 400);
    }

    public function edit_ajax($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|max:255',
                'kategori_nama' => 'required|string|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $kategori = KategoriModel::find($id);
            if ($kategori) {
                $kategori->update($request->all());
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

    public function destroy($id)
    {
        //
    }

    public function confirm_ajax($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    public function delete_ajax($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        $kategori->delete();
        if ($kategori) {
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
        $kategori = KategoriModel::with('barang')->findOrFail($id);
        $jumlahProduk = $kategori->barang->count();
        return view('kategori.detail_ajax', compact('kategori', 'jumlahProduk'));
    }

    public function import_ajax(Request $request)
    {
        $request->validate([
            'file_kategori' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            $file = $request->file('file_kategori');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            $insertData = [];
            $skippedData = [];
            $errors = [];

            // Ambil semua kategori_kode yang sudah ada di database sekaligus
            $existingCodes = \App\Models\KategoriModel::pluck('kategori_kode')->toArray();

            foreach ($data as $row => $values) {
                // Skip header row (assuming row 1 is header)
                if ($row == 1) continue;

                // Skip jika kategori_kode sudah ada
                if (in_array($values['A'], $existingCodes)) {
                    $skippedData[] = "Baris $row: Kategori dengan kode {$values['A']} sudah ada dan akan diabaikan";
                    continue;
                }

                // Validate each row
                $validator = Validator::make([
                    'kategori_kode' => $values['A'],
                    'kategori_nama' => $values['B'],
                ], [
                    'kategori_kode' => 'required|string|max:255',
                    'kategori_nama' => 'required|string|max:255',
                ]);

                if ($validator->fails()) {
                    $errors[] = "Baris $row: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                $insertData[] = [
                    'kategori_kode' => $values['A'],
                    'kategori_nama' => $values['B'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                // Tambahkan kode baru ke array existingCodes untuk pengecekan duplikat dalam file yang sama
                $existingCodes[] = $values['A'];
            }

            // Gabungkan skipped data dengan errors untuk informasi
            $allMessages = array_merge($skippedData, $errors);

            if (empty($insertData)) {
                return response()->json([
                    'status' => false,
                    'alert' => 'error',
                    'message' => 'Tidak ada data baru yang valid untuk diimport',
                    'info' => $allMessages
                ], 422);
            }

            // Gunakan insertOrIgnore untuk mengabaikan data yang duplicate
            $insertedCount = \App\Models\KategoriModel::insertOrIgnore($insertData);

            $response = [
                'status' => true,
                'alert' => 'success',
                'message' => 'Import data berhasil',
                'inserted_count' => $insertedCount,
                'skipped_count' => count($skippedData),
                'info' => $allMessages
            ];

            // Jika ada error validasi (selain duplikat)
            if (!empty($errors)) {
                $response['error_count'] = count($errors);
            }

            return response()->json($response, 200, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'alert' => 'error',
                'message' => 'Terjadi kesalahan saat memproses file',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function export_excel()
    {
        $kategori = \App\Models\KategoriModel::select('kategori_kode', 'kategori_nama')
            ->orderBy('kategori_kode')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Kategori');
        $sheet->setCellValue('C1', 'Nama Kategori');

        // Style header
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        // Fill data
        $no = 1;
        $row = 2;
        foreach ($kategori as $item) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $item->kategori_kode);
            $sheet->setCellValue('C' . $row, $item->kategori_nama);
            $row++;
            $no++;
        }

        // Auto size columns
        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set title sheet
        $sheet->setTitle("Data Kategori");

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Kategori ' . date("Y-m-d H:i:s") . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $kategori = \App\Models\KategoriModel::select('kategori_kode', 'kategori_nama')
            ->orderBy('kategori_kode')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('kategori.export_pdf', [
            'kategori' => $kategori
        ]);

        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('chroot', base_path('public'));

        return $pdf->stream('Data Kategori ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
