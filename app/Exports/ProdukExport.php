<?php

namespace App\Exports;

use App\Produk;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
// use Maatwebsite\Excel\Concerns\FromCollection;

class ProdukExport implements FromView, WithEvents, ShouldAutoSize
{
    use Exportable;

    public function registerEvents(): array
    {
        //MEMANIPULASI CELL
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                //CELL TERKAIT AKAN DI-MERGE
                $event->sheet->mergeCells('A1:C1');
                $event->sheet->mergeCells('A2:C2');
                $event->sheet->mergeCells('A3:B3');
                $event->sheet->mergeCells('A4:B4');

 
                //DEFINISIKAN STYLE UNTUK CELL
                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    // 'fill' => [
                    //     'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    //     'rotation' => 90,
                    //     'startColor' => [
                    //         'argb' => 'FFA0A0A0',
                    //     ],
                    //     'endColor' => [
                    //         'argb' => 'FFFFFFFF',
                    //     ],
                    // ],
                ];
                //CELL TERAKAIT AKAN MENGGUNAKAN STYLE DARI $styleArray
                $event->sheet->getStyle('A6:G6')->applyFromArray($styleArray);

 
                //FORMATTING STYLE UNTUK CELL TERKAIT
                $headCustomer = [
                    'font' => [
                        'bold' => true,
                    ]
                ];
                // $event->sheet->getStyle('A5:A7')->applyFromArray($headCustomer);
            },
        ];
    }

    public function view(): View
    {
        $produk = Produk::all();
        //MENGAMBIL DATA TRANSAKSI BERDASARKAN INVOICE YANG DITERIMA DARI CONTROLLER
        // $penjualan = Penjualan::where('invoice', $this->invoice)
        //     ->with('pelanggan', 'penjualan_detail', 'penjualan_detail.buku')->first();
        //DATA TERSEBUT DIPASSING KE FILE INVOICE_EXCEL
        return view('produk.report.export', [
            'produk' => $produk,
            // 'start_date' => date_format(date_create($this->start_date), "d/m/Y"),
            // 'end_date' => date_format(date_create($this->end_date), "d/m/Y"),
        ]);
    }
}
