<?php

namespace App\Notifications\Package\Member;

use PDF;
use Hashids;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendInvoice extends Notification implements ShouldQueue
{
    use Queueable;

    protected $req;
    protected $status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($req, $status)
    {
        $this->req    = $req;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $data = [
            'request' => $this->req,
            'status'  => $this->status,
        ];
        $pdf  = PDF::loadView('package.member.invoice', $data);
        $data = $pdf->output();

        if ($recipients = config('emails.admin.new_package_request.recipients')) {
            $recipients = explode(',', $recipients);

            array_walk($recipients, function (&$value) {
                $value = trim($value);
            });

            return (new MailMessage)
                ->subject((config('emails.package.' . ($this->status ? 'confirm' : 'request') . '.subject')) . ' - ' . $this->req->user->company . ' (#' . Hashids::connection('invoice')->encode($this->req->id) . ')')
                ->line(config('emails.package.' . ($this->status ? 'confirm' : 'request') . '.body'))
                ->bcc($recipients)
                ->attachData($data, 'invoice.pdf', [
                    'mime' => 'application/pdf',
                ]);
        } else {
            return (new MailMessage)
                ->subject(config('emails.package.' . ($this->status ? 'confirm' : 'request') . '.subject'))
                ->line(config('emails.package.' . ($this->status ? 'confirm' : 'request') . '.body'))
                ->attachData($data, 'invoice.pdf', [
                    'mime' => 'application/pdf',
                ]);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
