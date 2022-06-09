<?php

namespace App\Mail;

use App\Models\Transfers;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransferNotifySuccesMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $userSender=null,User $userReceiver=null,$transferValue=null)
    {
        $this->userSender=$userSender;
        $this->userReceiver=$userReceiver;
        $this->transfer=$transferValue;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.transfer_success_notify')
            ->subject('Sua transferência foi realizada com sucesso! :]')
            ->with([
                'userSenderName' => $this->userSender->full_name,
                'userReceiverName' => $this->userReceiver->full_name,
                'transferred_value' => $this->transfer,
            ]);
    }
}
