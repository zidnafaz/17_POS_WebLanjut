<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\DataTables\LevelDataTable;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class LevelController extends Controller
{

    public function index(LevelDataTable $dataTable)
    {
        $level_id = \App\Models\LevelModel::all();
        return $dataTable->render('level.index', compact('level_id'));
    }

    public function detail_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.detail_ajax', ['level' => $level]);
    }

    public function getLevels(LevelDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function create_ajax()
    {
        return view('level.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'level_kode' => 'required|string|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data level berhasil disimpan'
        ]);
    }

    public function edit_ajax(string $id)
    {
        $level = LevelModel::find($id);

        return view('level.edit_ajax', ['level' => $level]);
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|unique:m_level,level_kode,' . $id . ',level_id',
                'level_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $level = LevelModel::find($id);
            if ($level) {
                $level->update($request->all());
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
        $level = LevelModel::find($id);
        return view('level.confirm_ajax', ['level' => $level]);
    }

    public function delete_ajax(Request $request, string $id)
    {
        $level = LevelModel::find($id);
        if ($level) {
            $level->delete();
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

    public function import()
    {
        return view('level.import');
    }

    public function import_ajax(Request $request)
    {
        $request->validate([
            'file_level' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            $file = $request->file('file_level');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            $insertData = [];
            $skippedData = [];
            $errors = [];

            $existingCodes = \App\Models\LevelModel::pluck('level_kode')->toArray();

            foreach ($data as $row => $values) {
                if ($row == 1) continue;

                if (in_array($values['A'], $existingCodes)) {
                    $skippedData[] = "Baris $row: Level dengan kode {$values['A']} sudah ada dan akan diabaikan";
                    continue;
                }

                $validator = Validator::make([
                    'level_kode' => $values['A'],
                    'level_nama' => $values['B'],
                ], [
                    'level_kode' => 'required|string|max:255',
                    'level_nama' => 'required|string|max:255',
                ]);

                if ($validator->fails()) {
                    $errors[] = "Baris $row: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                $insertData[] = [
                    'level_kode' => $values['A'],
                    'level_nama' => $values['B'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $existingCodes[] = $values['A'];
            }

            $allMessages = array_merge($skippedData, $errors);

            if (empty($insertData)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data baru yang valid untuk diimport',
                    'info' => $allMessages
                ], 422);
            }

            $insertedCount = \App\Models\LevelModel::insertOrIgnore($insertData);

            $response = [
                'status' => true,
                'message' => 'Import data berhasil',
                'inserted_count' => $insertedCount,
                'skipped_count' => count($skippedData),
                'info' => $allMessages
            ];

            if (!empty($errors)) {
                $response['error_count'] = count($errors);
            }

            return response()->json($response, 200, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memproses file',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function export_excel()
    {
        $levels = \App\Models\LevelModel::select('level_kode', 'level_nama')
            ->orderBy('level_kode')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Level');
        $sheet->setCellValue('C1', 'Nama Level');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $row = 2;
        foreach ($levels as $level) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $level->level_kode);
            $sheet->setCellValue('C' . $row, $level->level_nama);
            $row++;
            $no++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle("Data Level");

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Level ' . date("Y-m-d H:i:s") . '.xlsx';

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
        $levels = \App\Models\LevelModel::select('level_kode', 'level_nama')
            ->orderBy('level_kode')
            ->get();

        $pdf = Pdf::loadView('level.export_pdf', [
            'levels' => $levels
        ]);

        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('chroot', base_path('public'));

        return $pdf->stream('Data Level ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
