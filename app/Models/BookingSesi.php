<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BookingSesi extends Model
{
    protected $table = 'booking_sesi';

    protected $fillable = [
        'kode_booking',
        'pasien_id',
        'layanan_terapi',
        'tgl_rencana',
        'keluhan_catatan',
        'status',
        'catatan_petugas',
        'dokter_id',
        'jam_sesi',
        'upt_lokasi',
        'rekam_id',
        'verified_by',
        'verified_at',
    ];

    public static function generateKodeBooking()
    {
        $yearMonth = date('ym');
        $prefix = 'BKG-' . $yearMonth . '-';

        $lastRecord = self::where('kode_booking', 'LIKE', $prefix . '%')
            ->orderBy('kode_booking', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $parts = explode('-', $lastRecord->kode_booking);
            if (isset($parts[2]) && is_numeric($parts[2])) {
                $nextNumber = (int)$parts[2] + 1;
            }
        }

        $formattedNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        $candidate = $prefix . $formattedNumber;

        while (self::where('kode_booking', $candidate)->exists()) {
            $nextNumber++;
            $formattedNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            $candidate = $prefix . $formattedNumber;
        }

        return $candidate;
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function rekam()
    {
        return $this->belongsTo(Rekam::class, 'rekam_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getStatusBadgeAttribute()
    {
        if ($this->status === 'disetujui') {
            return '<span class="badge font-w700" style="padding: 5px 10px; font-size: 11.5px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;"><i class="fa-solid fa-circle-check mr-1"></i> Terkonfirmasi</span>';
        } elseif ($this->status === 'ditolak') {
            return '<span class="badge font-w700" style="padding: 5px 10px; font-size: 11.5px; border-radius: 6px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;"><i class="fa-solid fa-circle-xmark mr-1"></i> Ditolak</span>';
        } elseif ($this->status === 'selesai') {
            return '<span class="badge font-w700" style="padding: 5px 10px; font-size: 11.5px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;"><i class="fa-solid fa-check-double mr-1"></i> Selesai</span>';
        } else {
            return '<span class="badge font-w700" style="padding: 5px 10px; font-size: 11.5px; border-radius: 6px; background: #fffbeb; color: #d97706; border: 1px solid #fde68a;"><i class="fa-solid fa-clock mr-1"></i> Menunggu Konfirmasi</span>';
        }
    }
}
