<?php

    namespace App\Mail;

    use App\Models\User;
    use App\Orderer;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Config;

    class OrdererMeetingReminder extends Mailable
    {
        use Queueable, SerializesModels;

        /**
         * The order instance.
         *
         * @var User
         */
        public $orderer;
        public $userType;
        public $conferenceUrl;
        public $subject = 'Занятие начнется через 10 минут';

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct(Orderer $orderer, $conferenceUrl, $userType)
        {
            $this->orderer = $orderer;
            $this->userType = $userType;
            $this->conferenceUrl = $conferenceUrl;
            $this->subject .= ' - ' . Config('global.project.title0');
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
                ->view('emails.orderer_meeting_reminder');
        }
    }