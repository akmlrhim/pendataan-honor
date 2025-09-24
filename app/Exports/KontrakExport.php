<?php

namespace App\Exports;

use App\Models\Kontrak;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class KontrakExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $tahun;
    protected $bulan;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $rows = collect();

        $kontraks = Kontrak::with(['mitra', 'tugas.anggaran', 'tugas'])
            ->whereMonth('periode', $this->bulan)
            ->whereYear('periode', $this->tahun)
            ->get();

        foreach ($kontraks as $kontrak) {
            $petugas = $kontrak->mitra->nms . "\n" .
                $kontrak->mitra->nama_lengkap . "\n" .
                $kontrak->mitra->alamat;

            $totalHonor = $kontrak->total_honor;
            $first = true;

            foreach ($kontrak->tugas as $tugas) {
                $rows->push([
                    'nomor_kontrak' => $first ? $kontrak->nomor_kontrak : '',
                    'petugas'       => $first ? $petugas : '',
                    'anggaran'      => $tugas->anggaran->kode_anggaran . "\n" .
                        $tugas->anggaran->nama_kegiatan,
                    'deskripsi'     => $tugas->deskripsi_tugas,
                    'jumlah'        => $tugas->jumlah_dokumen . ' ' . $tugas->satuan,
                    'harga_satuan'  => $tugas->harga_satuan,
                    'harga_total'   => $tugas->harga_total_tugas,
                    'total_honor'   => $first ? $totalHonor : '',
                ]);

                $first = false;
            }
        }

        return $rows;
    }


    public function headings(): array
    {
        return [
            'No Kontrak',
            'Petugas',
            'Anggaran',
            'Deskripsi Tugas',
            'Jumlah Dokumen',
            'Harga Satuan (Rp.)',
            'Harga Total Tugas (Rp.)',
            'Total Honor (Rp.)',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $rowCount = $sheet->getDelegate()->getHighestRow();
                $columnCount = $sheet->getDelegate()->getHighestColumn();

                //styling header
                $sheet->getStyle("A1:{$columnCount}1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4F81BD'],
                    ],
                ]);

                // Border semua sel
                $sheet->getStyle("A1:{$columnCount}{$rowCount}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Wrap text (tetap biar petugas & anggaran rapi)
                $sheet->getStyle("B2:B{$rowCount}")->getAlignment()->setWrapText(true);
                $sheet->getStyle("C2:C{$rowCount}")->getAlignment()->setWrapText(true);

                // Format angka rupiah
                $sheet->getStyle("F2:H{$rowCount}")
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                // Lebar kolom
                $sheet->getColumnDimension('A')->setWidth(15);
                $sheet->getColumnDimension('B')->setWidth(30);
                $sheet->getColumnDimension('C')->setWidth(30);
                $sheet->getColumnDimension('D')->setWidth(40);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(20);
                $sheet->getColumnDimension('G')->setWidth(20);
                $sheet->getColumnDimension('H')->setWidth(20);

                //merge cell perkontrak
                $currentContract = null;
                $startRow = 2;

                for ($row = 2; $row <= $rowCount; $row++) {
                    $contractNo = $sheet->getCell("A{$row}")->getValue();

                    if ($contractNo !== null && $contractNo !== '') {
                        if ($currentContract !== null) {
                            foreach (['A', 'B', 'H'] as $col) {
                                $sheet->mergeCells("{$col}{$startRow}:{$col}" . ($row - 1));
                            }
                        }
                        $currentContract = $contractNo;
                        $startRow = $row;
                    }

                    if ($row === $rowCount && $currentContract !== null) {
                        foreach (['A', 'B', 'H'] as $col) {
                            $sheet->mergeCells("{$col}{$startRow}:{$col}{$row}");
                        }
                    }
                }

                // perataan
                $sheet->getStyle("A2:H{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // perataan untuk desc tugas 
                $sheet->getStyle("D2:D{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setWrapText(true);
            },
        ];
    }
}
