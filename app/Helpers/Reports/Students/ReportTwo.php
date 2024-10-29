<?php
/**
 * File: ReportTwo
 * Created by: divino
 * Created at: 10/01/2024
 */

namespace App\Helpers\Reports\Students;

use App\Helpers\Reports\Report;

class ReportTwo extends \TCPDF
{
    use Report;

    protected $dojo;
    protected $address;

    public function generateBody()
    {
        $data = $this->getDataReportTwo();

        $this->addPage();

        $this->setX(15);

        $rowFormatters = $this->getRowFormat();

        $this->Cell(565, 10, 'Relatório Informativo 2', 0, 0, 'C');

        $this->Ln();
        $this->setXY(15, $this->getY() + 25);

        $this->addTitle($rowFormatters);

        foreach ($data as $row) {
            // Verifica se há espaço suficiente na página para o próximo registro
            if ($this->getY() > $this->getPageHeight() - 70) {
                $this->AddPage('P', 'A4', true); // Adiciona uma nova página
                $this->setX(15);

                $this->addTitle($rowFormatters);
            }

            $this->setX(15);
            $this->fontNormal(10);

            foreach ($rowFormatters as $formatter) {
                $this->Cell($formatter['width'], 10, $this->{$formatter['function']}($row[$formatter['field']]), 1, 0, $formatter['align']);
            }

            $this->Ln();
        }
    }

    protected function getRowFormat(): array
    {
        return [
            ['field' => 'name', 'align' => 'L', 'width' => 220, 'title' => 'Nome', 'title_align' => 'C', 'function' => 'unformatted'],
            ['field' => 'birthdate', 'align' => 'C', 'width' => 115, 'title' => 'Aniversário', 'title_align' => 'C', 'function' => 'formatDate'],
            ['field' => 'taxpayer', 'align' => 'C', 'width' => 115, 'title' => 'CPF', 'title_align' => 'C', 'function' => 'unformatted'],
            ['field' => 'taxpayer_code', 'align' => 'C', 'width' => 115, 'title' => 'RG', 'title_align' => 'C', 'function' => 'unformatted'],
        ];
    }
}