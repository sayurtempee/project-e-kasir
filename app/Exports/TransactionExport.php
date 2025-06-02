<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TransactionExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $total = 0;

    public function collection()
    {
        $transactions = Transaction::with('product.category')->get();
        $this->total = $transactions->sum('total_price');
        return $transactions;
    }

    public function headings(): array
    {
        return [
            'Nama Produk',         // A
            'Jumlah',              // B
            'Harga',               // C
            'Total Harga',         // D
            'Tanggal Transaksi',   // E
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->product->name,
            $transaction->quantity,
            'Rp' . number_format($transaction->product->price, 0, ',', '.'),
            'Rp' . number_format($transaction->total_price, 0, ',', '.'),
            $transaction->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $rowCount = count($sheet->toArray()); // termasuk heading
                $totalRow = $rowCount + 1;

                // Set tinggi baris
                $sheet->getDefaultRowDimension()->setRowHeight(20);

                // Font size
                $sheet->getStyle("A1:F{$totalRow}")->getFont()->setSize(12);

                // Alignment semua data
                $sheet->getStyle("A2:F{$rowCount}")
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A2:F{$rowCount}")
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

                // Konversi inch ke excel width
                $inchesToExcelWidth = fn ($inches) => $inches * 7;

                // Lebar kolom
                $sheet->getColumnDimension('A')->setWidth($inchesToExcelWidth(2.5));
                $sheet->getColumnDimension('B')->setWidth($inchesToExcelWidth(2.0));
                $sheet->getColumnDimension('C')->setWidth($inchesToExcelWidth(2.5));
                $sheet->getColumnDimension('D')->setWidth($inchesToExcelWidth(2.5));
                $sheet->getColumnDimension('E')->setWidth($inchesToExcelWidth(3.0));
                // $sheet->getColumnDimension('F')->setWidth($inchesToExcelWidth(3.0));

                // Gabungkan kolom A sampai F
                $sheet->mergeCells("A{$totalRow}:E{$totalRow}");

                // Hitung total keseluruhan dari total_price (sum dari total harga setiap transaksi)
                $totalAmount = $this->total; // Total keseluruhan dari Transaction::sum('total_price')

                // Format Total Keseluruhan
                $totalFormatted = 'Total Keseluruhan: Rp' . number_format($totalAmount, 0, ',', '.');

                // Set nilai dan alignment
                $sheet->setCellValue("A{$totalRow}", $totalFormatted);
                $sheet->getStyle("A{$totalRow}:E{$totalRow}")
                    ->getFont()->setBold(true);
                $sheet->getStyle("A{$totalRow}:E{$totalRow}")
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            },
        ];
    }
}
