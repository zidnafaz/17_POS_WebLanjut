<?php

namespace App\Http\Controllers;

use App\Models\SuplierModel;
use Illuminate\Http\Request;
use App\DataTables\SuplierDataTable;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class SuplierController extends Controller
{
    public function index(SuplierDataTable $dataTable)
    {
        return $dataTable->render('suplier.index');
    }

    public function create_ajax()
    {
        return view('suplier.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $request->validate([
            'kode_suplier' => 'required|string|max:10',
            'nama_suplier' => 'required|string|max:100',
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        SuplierModel::create([
            'kode_suplier' => $request->kode_suplier,
            'nama_suplier' => $request->nama_suplier,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return response()->json(['success' => true]);
    }

    public function edit_ajax($id)
    {
        $suplier = SuplierModel::findOrFail($id);
        return view('suplier.edit_ajax', compact('suplier'));
    }

    public function update_ajax(Request $request, $id)
    {
        $request->validate([
            'kode_suplier' => 'required|string|max:10',
            'nama_suplier' => 'required|string|max:100',
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $suplier = SuplierModel::findOrFail($id);
        $suplier->update([
            'kode_suplier' => $request->kode_suplier,
            'nama_suplier' => $request->nama_suplier,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return response()->json(['success' => true]);
    }

    public function confirm_ajax($id)
    {
        $suplier = SuplierModel::findOrFail($id);
        return view('suplier.confirm_ajax', compact('suplier'));
    }

    public function delete_ajax($id)
    {
        $suplier = SuplierModel::findOrFail($id);
        $suplier->delete();

        return response()->json(['success' => true]);
    }

    public function detail_ajax($id)
    {
        $suplier = SuplierModel::findOrFail($id);
        return view('suplier.detail_ajax', compact('suplier'));
    }

    public function import()
    {
        return view('suplier.import');
    }

    public function import_ajax(Request $request)
    {
        $request->validate([
            'file_suplier' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            $file = $request->file('file_suplier');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            $insertData = [];
            $skippedData = [];
            $errors = [];

            $existingCodes = SuplierModel::pluck('kode_suplier')->toArray();

            foreach ($data as $row => $values) {
                if ($row == 1) continue;

                if (in_array($values['A'], $existingCodes)) {
                    $skippedData[] = "Baris $row: Suplier dengan kode {$values['A']} sudah ada dan akan diabaikan";
                    continue;
                }

                $validator = \Illuminate\Support\Facades\Validator::make([
                    'kode_suplier' => $values['A'],
                    'nama_suplier' => $values['B'],
                    'no_telepon' => $values['C'],
                    'alamat' => $values['D'],
                ], [
                    'kode_suplier' => 'required|string|max:10',
                    'nama_suplier' => 'required|string|max:100',
                    'no_telepon' => 'nullable|string|max:15',
                    'alamat' => 'nullable|string',
                ]);

                if ($validator->fails()) {
                    $errors[] = "Baris $row: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                $insertData[] = [
                    'kode_suplier' => $values['A'],
                    'nama_suplier' => $values['B'],
                    'no_telepon' => $values['C'],
                    'alamat' => $values['D'],
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

            $insertedCount = SuplierModel::insertOrIgnore($insertData);

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
        $supliers = SuplierModel::select('kode_suplier', 'nama_suplier', 'no_telepon', 'alamat')
            ->orderBy('kode_suplier')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Kode Suplier');
        $sheet->setCellValue('B1', 'Nama Suplier');
        $sheet->setCellValue('C1', 'No Telepon');
        $sheet->setCellValue('D1', 'Alamat');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $row = 2;
        foreach ($supliers as $suplier) {
            $sheet->setCellValue('A' . $row, $suplier->kode_suplier);
            $sheet->setCellValue('B' . $row, $suplier->nama_suplier);
            $sheet->setCellValue('C' . $row, $suplier->no_telepon);
            $sheet->setCellValue('D' . $row, $suplier->alamat);
            $row++;
        }

        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle("Data Suplier");

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Suplier ' . date("Y-m-d H:i:s") . '.xlsx';

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
        $supliers = SuplierModel::select('kode_suplier', 'nama_suplier', 'no_telepon', 'alamat')
            ->orderBy('kode_suplier')
            ->get();

        $pdf = Pdf::loadView('suplier.export_pdf', [
            'supliers' => $supliers
        ]);

        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('chroot', base_path('public'));

        return $pdf->stream('Data Suplier ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
