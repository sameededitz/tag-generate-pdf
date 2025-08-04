<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpiryTagGenerator extends Component
{
    public $title, $address, $mfg_date, $exp_date;
    public $custom_days;

    protected $dateFormat = 'm-d-y';

    public function mount()
    {
        $this->title = 'A.S Bakers';
        $this->address = 'RachnaTown, Main Bazar, Faisalabad';
        $this->mfg_date = now()->format('m-d-y');
        $this->exp_date = now()->addDays(7)->format('m-d-y');
    }

    public function generatePDF()
    {
        try {
            $mfg = Carbon::createFromFormat($this->dateFormat, $this->mfg_date);
            $exp = Carbon::createFromFormat($this->dateFormat, $this->exp_date);
        } catch (\Exception $e) {
            $this->addError('mfg_date', 'Invalid date format.');
            return;
        }

        // Temporarily override validated attributes with parsed versions
        $validatedData = [
            'title' => $this->title,
            'address' => $this->address,
            'mfg_date' => $mfg->format('Y-m-d'),
            'exp_date' => $exp->format('Y-m-d'),
        ];

        // Manually validate
        validator($validatedData, [
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'mfg_date' => 'required|date',
            'exp_date' => 'required|date|after_or_equal:mfg_date',
        ])->validate();

        $data = [
            'title' => $this->title,
            'address' => $this->address,
            'mfg_date' => $this->mfg_date,
            'exp_date' => $this->exp_date,
        ];

        $pdf = Pdf::loadView('exports.pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif'
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'expiry_tags_' . now()->format('YmdHis') . '.pdf');
    }

    public function render()
    {
        /** @disregard @phpstan-ignore-line */
        return view('livewire.expiry-tag-generator')
            ->extends('layouts.app')
            ->section('content');
    }

    public function setExpiry($days)
    {
        if (!$this->mfg_date) {
            $this->addError('mfg_date', 'Please select MFG date first.');
            return;
        }

        try {
            $baseDate = Carbon::createFromFormat($this->dateFormat, $this->mfg_date);

            $this->exp_date = $baseDate
                ->addDays(intval($days))
                ->format($this->dateFormat);
        } catch (\Exception $e) {
            $this->addError('mfg_date', 'Invalid MFG date format.');
        }
    }

    public function setCustomExpiry()
    {
        if (!$this->mfg_date) {
            $this->addError('mfg_date', 'Please select MFG date first.');
            return;
        }

        if (!is_numeric($this->custom_days) || $this->custom_days < 0) {
            $this->addError('custom_days', 'Enter a valid number of days.');
            return;
        }

        $days = $this->custom_days;
        if (empty($days)) {
            $this->addError('custom_days', 'Please enter the number of days.');
            return;
        }

        try {
            $baseDate = Carbon::createFromFormat($this->dateFormat, $this->mfg_date);

            $this->exp_date = $baseDate
                ->addDays(intval($days))
                ->format($this->dateFormat);
        } catch (\Exception $e) {
            $this->addError('mfg_date', 'Invalid MFG date format.');
        }
    }
}
