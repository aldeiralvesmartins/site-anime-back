<?php
/**
 * File: Report
 * Created by: divino
 * Created at: 09/01/2024
 */

namespace App\Helpers\Reports;

use App\Models\Address;
use App\Models\Dojo;
use App\Models\Student;
use Carbon\Carbon;

trait Report
{
    public function Header()
    {
        $logoPath = storage_path("app/logos/{$this->dojo->id}.png");

        $textAlign = 'C';
        $text_margin_left = 15;

        $fontSize = [14, 10, 8, 8];

        $this->Image($logoPath, 30, 12.5, '', 50, '', '', 'T', true);

        $this->fontBold($fontSize[0]);

        $this->SetXY($text_margin_left, 12.50);

        $this->Cell(0, 0, $this->dojo->name, 0, 0, $textAlign);

        $this->fontNormal($fontSize[1]);

        $this->SetXY($text_margin_left, 33);

        $this->Cell(0, 0, 'Contato da Empresa', 0, 0, $textAlign);

        $this->fontNormal($fontSize[2]);

        $this->SetXY($text_margin_left, 50);

        $this->Cell(0, 0, $this->getAddress(), '', 0, $textAlign);

        $this->Line(15, 75, ($this->getPageWidth() - 15), 75);

        $this->Ln();

        $this->SetMargins(15, 100, 15);
    }

    protected function addTitle($formats): void
    {
        $this->SetFillColor(200, 200, 200);
        $this->fontNormal(12);

        foreach ($formats as $format) {
            $this->Cell($format['width'], 10, $format['title'], 1, 0, $format['title_align'], true);
        }

        $this->SetFillColor(255, 255, 255);
        $this->Ln();
    }

    public function getDatasReportOne(): array
    {
        $datas = Student::select('name', 'height', 'weight', 'graduation_id')->with('graduation')->get();

        return array_map(fn($item) => [
            'name' => $item['name'],
            'graduation' => $item['graduation']['name'] ?? null,
            'height' => $item['height'],
            'weight' => $item['weight'],
        ], $datas->toArray());
    }

    public function getDataReportTwo(): array
    {
        $data = Student::select('name', 'birthdate', 'taxpayer', 'taxpayer_code')->get();

        return array_map(fn($item) => [
            'name' => $item['name'],
            'birthdate' => $item['birthdate'],
            'taxpayer' => $item['taxpayer'],
            'taxpayer_code' => $item['taxpayer_code'],
        ], $data->toArray());
    }

    public function getDataReportThree(): array
    {
        $data = Student::select('name', 'birthdate', 'graduation_id', 'height', 'weight')->with('graduation')->get();

        return array_map(fn($item) => [
            'name' => $item['name'],
            'birthdate' => $item['birthdate'],
            'graduation' => $item['graduation']['name'] ?? null,
            'height' => $item['height'],
            'weight' => $item['weight'],
        ], $data->toArray());
    }

    public function Footer(): void
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    protected function unformatted($value, $limit = 0):? string
    {
        if ($limit > 0) {
            return substr($value, 0, $limit);
        }

        return $value;
    }

    public function setDojo($dojoId)
    {
        $dojo = Dojo::find($dojoId);
        $address = Address::where('id', $dojo->address_id)->with('city', fn($q) => $q->with('state'))->first();

        $this->address = $address;
        $this->dojo = $dojo;
    }

    protected function formatWeight($value):? string
    {
        if ($value) {
            return (float) $value . ' Kg';
        }

        return null;
    }

    protected function formatDate($value): string
    {
        if ($value) {
            return Carbon::parse($value)->format('d/m/Y');
        }

        return '';
    }

    protected function formatHeight($value):? string
    {
        if ($value) {
            return (float) $value . 'm';
        }

        return null;
    }

    public function getAddress(): string
    {
        $address = $this->address?->street;

        if ($address) {
            $number = $this->address?->number;
            $complement = $this->address?->complement;
            $neighborhood = $this->address?->neighborhood;

            $cityName = $this->address?->city?->name;
            $state = $this->address?->city?->state?->acronyms;

            $address .= $number ? ", $number" : '';
            $address .= $complement ? ", $complement" : '';
            $address .= $neighborhood ? " - $neighborhood" : '';
            $address .= $cityName ? " - $cityName" : '';
            $address .= $state ? " - $state" : '';

            return $address;
        }

        return '';
    }

    protected function defineFont($font, $style, $size)
    {
        $this->setFont($font, $style, $size);
    }

    //todo font normal deve ser a arial mas não tem ela no servidor.
    public function fontNormal($size)
    {
        $this->setFont('helvetica', '', $size);
    }

    public function fontBold($size)
    {
        $this->setFont('helvetica', 'B', $size);
    }
}