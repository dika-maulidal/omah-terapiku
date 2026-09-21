<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingBaruNotification extends Notification
{
    use Queueable;

    public $booking;
    public $message;

    /**
     * Create a new notification instance.
     *
     * @param mixed $booking
     * @param string|null $message
     */
    public function __construct($booking, $message = null)
    {
        $this->booking = $booking;
        $namaPasien = ($booking && $booking->pasien) ? $booking->pasien->nama : 'Penerima Manfaat';
        $this->message = $message ?: "Permohonan Booking Sesi ({$booking->kode_booking}) atas nama {$namaPasien} telah diajukan dan menunggu persetujuan.";
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
        $pasien = $this->booking ? $this->booking->pasien : null;
        $createdAt = ($this->booking && $this->booking->created_at)
            ? (is_string($this->booking->created_at) ? \Carbon\Carbon::parse($this->booking->created_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s') : $this->booking->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i:s'))
            : now('Asia/Jakarta')->format('Y-m-d H:i:s');

        return [
            'id_booking' => $this->booking ? $this->booking->id : null,
            'kode_booking' => $this->booking ? $this->booking->kode_booking : '-',
            'id_pasien' => $this->booking ? $this->booking->pasien_id : null,
            'nama_pasien' => $pasien ? $pasien->nama : 'Penerima Manfaat',
            'no_rm' => $pasien ? ($pasien->no_rm ?? '-') : '-',
            'layanan_terapi' => $this->booking ? ($this->booking->layanan_terapi ?? 'Booking Sesi') : 'Booking Sesi',
            'sesi_waktu' => $this->booking ? ($this->booking->jam_sesi ?? '-') : '-',
            'tgl_rencana' => $this->booking ? $this->booking->tgl_rencana : null,
            'upt_lokasi' => $this->booking ? ($this->booking->upt_lokasi ?? '-') : '-',
            'message' => $this->message,
            'tipe' => 'booking_baru',
            'created_at' => $createdAt,
            'target_url' => route('booking.index'),
        ];
    }
}
