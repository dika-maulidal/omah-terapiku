<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PendaftaranBaruNotification extends Notification
{
    use Queueable;

    public $pendaftaran;
    public $message;

    /**
     * Create a new notification instance.
     *
     * @param mixed $pendaftaran
     * @param string|null $message
     */
    public function __construct($pendaftaran, $message = null)
    {
        $this->pendaftaran = $pendaftaran;
        $this->message = $message ?: "Pendaftaran Penerima Manfaat Baru ({$pendaftaran->kode_pendaftaran}) atas nama {$pendaftaran->nama} telah diajukan dan menunggu verifikasi.";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $createdAt = ($this->pendaftaran && $this->pendaftaran->created_at)
            ? (is_string($this->pendaftaran->created_at) ? $this->pendaftaran->created_at : $this->pendaftaran->created_at->format('Y-m-d H:i:s'))
            : now()->format('Y-m-d H:i:s');

        return [
            'id_pendaftaran' => $this->pendaftaran ? $this->pendaftaran->id : null,
            'kode_pendaftaran' => $this->pendaftaran ? $this->pendaftaran->kode_pendaftaran : '-',
            'nama_pasien' => $this->pendaftaran ? $this->pendaftaran->nama : 'Penerima Manfaat Baru',
            'no_rm' => '-',
            'layanan_terapi' => $this->pendaftaran ? ($this->pendaftaran->layanan_terapi ?? 'Pendaftaran Baru') : 'Pendaftaran Baru',
            'sesi_waktu' => $this->pendaftaran ? ($this->pendaftaran->jam_rencana_kunjungan ?? '-') : '-',
            'tgl_rencana' => $this->pendaftaran ? $this->pendaftaran->tgl_rencana_kunjungan : null,
            'upt_lokasi' => $this->pendaftaran ? ($this->pendaftaran->upt_lokasi ?? '-') : '-',
            'message' => $this->message,
            'tipe' => 'pendaftaran_baru',
            'created_at' => $createdAt,
            'target_url' => route('pendaftaran.index'),
        ];
    }
}
