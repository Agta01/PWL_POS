<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\DetailPenjualanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\pdf;

class PenjualanController extends Controller
{
    public function index()
    {
        $activeMenu = 'penjualan';
        $breadcrumb = (object)[
            'title' => 'Data Penjualan',
            'list' => ['Home', 'Penjualan']
        ];
        $penjualan = PenjualanModel::select('t_penjualan.penjualan_id', 'pembeli')->get();
        return view('penjualan.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'penjualan' => $penjualan
        ]);
    }

    public function list(Request $request)
    {
        // pemilihan kolom
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode', 'pembeli', 'user_id')
            ->with('m_user');
        
        // Ambil filter dari request jika ada
        $penjualan_id = $request->input('filter_penjualan');
        
        if (!empty($penjualan_id)) {
            $penjualan->where('penjualan_id', $penjualan_id);
        }
    
        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($penjualan) {
                $btn = '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->addColumn('harga', function ($penjualan) {
                return number_format($penjualan->detailPenjualan->harga ?? 0, 0, ',', '.');
            })
            ->addColumn('jumlah', function ($penjualan) {
                return $penjualan->detailPenjualan->jumlah ?? 0;
            })
            ->rawColumns(['aksi']) // rawColumns digunakan agar HTML yang ada dalam 'aksi' dirender dengan benar
            ->make(true);
    }
    


    public function show_ajax(string $id) {
        $penjualan = PenjualanModel::find($id);
        if ($penjualan) {
            // Tampilkan halaman show_ajax dengan data penjualan
            return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
        } else {
            // Tampilkan pesan kesalahan jika penjualan tidak ditemukan
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
    

    public function create_ajax()
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'pembeli')->get();
        return view('penjualan.create_ajax')->with('penjualan', $penjualan);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id' => ['required', 'integer', 'exists:t_penjualan,penjualan_id'],
                'penjualan_kode' => ['required', 'min:3', 'max:20', 'unique:t_penjualan,penjualan_kode'],
                'pembeli' => ['required', 'string', 'max:100'],
                'penjualan_tanggal' => ['required', 'date'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            PenjualanModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax($id)
    {
        $penjualan = PenjualanModel::find($id);
        $penjualan = PenjualanModel::select('penjualan_id', 'pembeli')->get();
        return view('penjualan.edit_ajax', ['penjualan' => $penjualan, 'penjualan' => $penjualan]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id' => ['required', 'integer', 'exists:m_penjualan,penjualan_id'],
                'penjualan_kode' => ['required', 'min:3', 'max:20', 'unique:m_penjualan,penjualan_kode, ' . $id . ',penjualan_id'],
                'pembeli' => ['required', 'string', 'max:100'],
                'penjualan_tanggal' => ['required', 'date'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = PenjualanModel::find($id);
            if ($check) {
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

    public function confirm_ajax($id)
    {
        $penjualan = PenjualanModel::find($id);
        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
    }


    public function delete_ajax(Request $request, $id)
    {
        // Cek apakah request dari Ajax
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if ($penjualan) {
                $penjualan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data penjualan tidak ditemukan'
                ]);
            }

        } else {
            return redirect('/');
        }
    }

    public function import()
    {
        return view('penjualan.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_penjualan' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_penjualan');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'penjualan_id' => $value['A'],
                            'penjualan_kode' => $value['B'],
                            'pembeli' => $value['C'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    PenjualanModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }

        return redirect('/');
    }

    public function export_excel()
    {
        // ambil data penjualan yang akan di export 
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode', 'pembeli','nama', 'penjualan_tanggal')
        ->orderBy('penjualan_id')
        ->with('m_user')
        ->get();

        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif 

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode penjualan');
        $sheet->setCellValue('C1', 'Pembeli');
        $sheet->setCellValue('D1', 'Nama Pembeli');
        $sheet->setCellValue('E1', 'Tanggal');
      

        $sheet->getStyle('A1:E1')->getFont()->setBold(true); // bold header

        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($penjualan as $key => $value) {
            $sheet->setCellValue('A'. $baris, $no);
            $sheet->setCellValue('B'. $baris, $value->penjualan_kode);
            $sheet->setCellValue('C'. $baris, $value->pembeli);
            $sheet->setCellValue('D'. $baris, $value->nama);
            $sheet->setCellValue('E'. $baris, $value->tanggal);
            $baris++;
            $no++;
        }

        foreach(range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutosize(true); // set auto size untuk kolom
        }

        $sheet->setTitle('Data penjualan'); // set title sheet

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data penjualan'. date('Y-m-d H:i:s'). '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename.'"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s'). ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    } // end function export_excel

    public function export_pdf()
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode', 'pembeli', 'nama', 'penjualan_tanggal')
                ->orderBy('penjualan_id')
                ->orderBy('penjualan_kode')
                ->with('m_user')
                ->get();

        // use Barryvdh\DomPDF\Facade\pdf;
        $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('a4', 'potrait'); // set ukuran kertas dan orientasi 
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data penjualan' .date('Y-m-d H:i:s'). '.pdf');

    }
}