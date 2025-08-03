<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpiryTagGenerator extends Component
{
    public $title, $address, $mfg_date, $exp_date;
    public $custom_days;

    public function mount()
    {
        $this->title = 'A.S Bakers';
        $this->address = 'RachnaTown, Main Bazar, Faisalabad';
        $this->mfg_date = now()->toDateString();
        $this->exp_date = now()->addDays(7)->toDateString();
    }

    public function generatePDF()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'mfg_date' => 'required|date',
            'exp_date' => 'required|date|after_or_equal:mfg_date',
        ]);

        $data = [
            'title' => $this->title,
            'address' => $this->address,
            'mfg_date' => $this->mfg_date,
            'exp_date' => $this->exp_date,
        ];

        $pdf = Pdf::loadView('exports.pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif'
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'expiry_tags.pdf');
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

        $parsedDays = intval($days); // in case user enters string

        $this->exp_date = \Carbon\Carbon::parse($this->mfg_date)
            ->addDays($parsedDays)
            ->format('Y-m-d');
    }

    public function setCustomExpiry()
    {
        // dd($this->custom_days);
        if (!$this->mfg_date) {
            $this->addError('mfg_date', 'Please select MFG date first.');
            return;
        }

        if (!is_numeric($this->custom_days) || $this->custom_days < 0) {
            $this->addError('custom_days', 'Enter a valid number of days.');
            return;
        }

        $this->exp_date = Carbon::parse($this->mfg_date)
            ->addDays((int)$this->custom_days)
            ->format('Y-m-d');
    }
}
