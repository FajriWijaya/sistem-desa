<?php

namespace App\Exports;

use App\Models\Dusun;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TemplatePendudukExport implements WithEvents
{
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $spreadsheet = $event->sheet->getParent();
                $input = $event->sheet->getDelegate();

                // ========================
                // SHEET MASTER
                // ========================
                $master = $spreadsheet->createSheet();
                $master->setTitle('Master');

                $row = 1;

                $dusuns = Dusun::with('rw.rt')->get();

                $dusunList = [];

                foreach ($dusuns as $dusun) {

                    $dusunName = $this->clean($dusun->nama_dusun);
                    $dusunList[] = $dusunName;

                    $startRwRow = $row;

                    foreach ($dusun->rw as $rw) {
                        $master->setCellValue("A$row", $rw->no_rw);
                        $row++;
                    }

                    // Named Range RW
                    $spreadsheet->addNamedRange(
                        new NamedRange(
                            $dusunName,
                            $master,
                            "A$startRwRow:A" . ($row - 1)
                        )
                    );

                    // RT per RW
                    foreach ($dusun->rw as $rw) {

                        $rtStart = $row;
                        $rwKey = $dusunName . '_' . $rw->no_rw;

                        foreach ($rw->rt as $rt) {
                            $master->setCellValue("B$row", $rt->no_rt);
                            $row++;
                        }

                        if ($rtStart < $row) {
                            $spreadsheet->addNamedRange(
                                new NamedRange(
                                    $rwKey,
                                    $master,
                                    "B$rtStart:B" . ($row - 1)
                                )
                            );
                        }
                    }

                    $row++;
                }

                // ========================
                // NAMED RANGE DUSUN
                // ========================
                $master->fromArray($dusunList, null, 'D1');

                $spreadsheet->addNamedRange(
                    new NamedRange(
                        'DUSUN',
                        $master,
                        'D1:D' . count($dusunList)
                    )
                );

                // ========================
                // SHEET INPUT
                // ========================
                $input->setCellValue('A1', 'nik');
                $input->setCellValue('B1', 'nama_lengkap');
                $input->setCellValue('C1', 'jenis_kelamin');
                $input->setCellValue('D1', 'tempat_lahir');
                $input->setCellValue('E1', 'tanggal_lahir');
                $input->setCellValue('F1', 'agama');
                $input->setCellValue('G1', 'pendidikan');
                $input->setCellValue('H1', 'profesi');
                $input->setCellValue('I1', 'status_perkawinan');
                $input->setCellValue('J1', 'golongan_darah');
                $input->setCellValue('K1', 'kewarganegaraan');
                $input->setCellValue('L1', 'nama_ibu');
                $input->setCellValue('M1', 'nama_ayah');
                $input->setCellValue('N1', 'nama_dusun');
                $input->setCellValue('O1', 'no_rw');
                $input->setCellValue('P1', 'no_rt');

                for ($i = 2; $i <= 100; $i++) {

                    // Dusun
                    $dvDusun = new DataValidation();
                    $dvDusun->setType(DataValidation::TYPE_LIST);
                    $dvDusun->setFormula1('=DUSUN');
                    $input->getCell("N$i")->setDataValidation($dvDusun);

                    // RW (berdasarkan dusun)
                    $dvRw = new DataValidation();
                    $dvRw->setType(DataValidation::TYPE_LIST);
                    $dvRw->setFormula1("=INDIRECT(N$i)");
                    $input->getCell("O$i")->setDataValidation($dvRw);

                    // RT (berdasarkan dusun + rw)
                    $dvRt = new DataValidation();
                    $dvRt->setType(DataValidation::TYPE_LIST);
                    $dvRt->setFormula1("=INDIRECT(N$i&\"_\"&O$i)");
                    $input->getCell("P$i")->setDataValidation($dvRt);
                }
            }
        ];
    }

    // 🔧 bersihin nama biar valid untuk named range
    private function clean($text)
    {
        return str_replace(' ', '_', $text);
    }
}