<?php

    namespace App\Mail;

    use App\Models\User;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Config;

    class SupplierRejected extends Mailable
    {
        use Queueable, SerializesModels;

        /**
         * The order instance.
         *
         * @var User
         */
        public $user;
        public $emailTo;
        public $subject = 'В регистрации поставщика отказано - ';
        public $rejectReason;

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct(User $user, $rejectReason = '')
        {
            $this->user = $user;
            $this->emailTo = $user->email;
            $this->rejectReason = $rejectReason;
            $this->subject .= Config('global.project.title0');
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {
            return $this
                ->from( Config('global.project.email') , Config('global.project.webname') )
                ->subject($this->subject)
                ->view('emails.supplier_rejected');
        }
    }