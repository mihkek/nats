<?php

    namespace App\Mail;

    use App\Models\User;
    use App\Auction;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Config;

    class LoseAuction extends Mailable
    {
        use Queueable, SerializesModels;

        /**
         * The order instance.
         *
         * @var User
         */
        public $auction;
        public $lose_rate;
        public $rate;
        public $conferenceUrl;
        public $subject = 'Аукцион был завершен. Ваша ставка проиграла.';

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct(Auction $auction, $lose_rate, $rate, $conferenceUrl)
        {
            $this->auction = $auction;
            $this->lose_rate = $lose_rate;
            $this->rate = $rate;
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
                ->view('emails.lose_auction');
        }
    }