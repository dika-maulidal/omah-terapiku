<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RekamUpdateNotification extends Notification
{
    use Queueable;

    public $rekams;
    public $message;
    public $tipe;

    /**
     * Create a new notification instance.
     *
     * @param mixed $rekams
     * @param string $message
     * @param string $tipe
     */
    public function __construct($rekams, $message, $tipe = 'assignment')
    {
        $this->rekams = $rekams;
        $this->message = $message;
        $this->tipe = $tipe;
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

    public function toArray($notifiable)
    {
        $pasien = $this->rekams ? $this->rekams->pasien : null;
        $createdAt = ($this->rekams && $this->rekams->created_at)
            ? (is_string($this->rekams->created_at) ? $this->rekams->created_at : $this->rekams->created_at->format('Y-m-d H:i:s'))
            : now()->format('Y-m-d H:i:s');

        return [
            'id_rekam' => $this->rekams ? $this->rekams->id : null,
            'no_rekam' => $this->rekams ? ($this->rekams->no_rekam ?? '-') : '-',
            'created_at' => $createdAt,
            'id_pasien' => $this->rekams ? $this->rekams->pasien_id : null,
            'nama_pasien' => $pasien ? $pasien->nama : 'Penerima Manfaat',
            'no_rm' => $pasien ? $pasien->no_rm : '-',
            'layanan_terapi' => $this->rekams ? ($this->rekams->layanan_terapi ?? 'Terapi') : 'Terapi',
            'sesi_waktu' => $this->rekams ? ($this->rekams->sesi_waktu ?? '-') : '-',
            'poli' => $this->rekams ? ($this->rekams->poli ?? '-') : '-',
            'message' => $this->message,
            'tipe' => $this->tipe,
        ];
    }
}
