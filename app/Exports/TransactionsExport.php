<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaction::with(['user', 'event.user'])
            ->get()
            ->map(function ($transaction) {
                return [
                    'ID Transaksi' => $transaction->id,
                    'Nama Pembeli' => $transaction->user->name ?? '-',
                    'Email Pembeli' => $transaction->user->email ?? '-',
                    'Event' => $transaction->event->title ?? '-',
                    'Penyelenggara' => $transaction->event->user->name ?? '-',
                    'Jumlah Tiket' => $transaction->ticket_count,
                    'Total' => $transaction->total_amount,
                    'Komisi' => $transaction->commission_amount,
                    'Tanggal' => $transaction->created_at ? $transaction->created_at->format('d-m-Y H:i') : '-',
                    'Status' => $transaction->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Nama Pembeli',
            'Email Pembeli',
            'Event',
            'Penyelenggara',
            'Jumlah Tiket',
            'Total',
            'Komisi',
            'Tanggal',
            'Status',
        ];
    }
}
