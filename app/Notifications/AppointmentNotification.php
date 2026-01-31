<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentNotification extends Notification
{
    use Queueable;

    public $appointment;
    public $type; // 'new_booking' or 'status_update'

    /**
     * Create a new notification instance.
     */
    public function __construct($appointment, $type = 'status_update')
    {
        $this->appointment = $appointment;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = '';
        $link = '#';

        if ($this->type === 'new_booking') {
            $patientName = $this->appointment->patientProfile->user->name ?? 'Một bệnh nhân';
            $message = "Bạn có lịch hẹn mới từ {$patientName} vào ngày {$this->appointment->date} lúc {$this->appointment->time}.";
            $link = route('doctor.appointments');
        } elseif ($this->type === 'status_update') {
            $status = $this->appointment->status;
            $doctorName = $this->appointment->doctorProfile->user->name ?? 'Bác sĩ';
            
            $statusText = match($status) {
                'confirmed' => 'đã được xác nhận',
                'cancelled' => 'đã bị hủy',
                'completed' => 'đã hoàn thành',
                'pending' => 'đang chờ xác nhận',
                default => 'đã cập nhật'
            };

            $message = "Lịch hẹn của bạn với BS. {$doctorName} {$statusText}.";
            $link = route('my.appointments');
        }

        return [
            'appointment_id' => $this->appointment->id,
            'message' => $message,
            'link' => $link,
            'type' => $this->type,
        ];
    }
}
