<?php

    namespace App\Mail;

    use App\Models\User;
    use App\Auction;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Config;

    class NewAuctionRate extends Mailable
    {
        use Queueable, SerializesModels;

        /**
         * The order instance.
         *
         * @var User
         */
        public $auction;
        public $rate;
        public $last_rate;
        public $conferenceUrl;
        public $subject = 'Новая ставка по аукциону';

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct(Auction $auction, $rate, $last_rate, $conferenceUrl)
        {
            $this->auction = $auction;
            $this->rate = $rate;
            $this->last_rate = $last_rate;
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
                ->view('emails.new_auction_rate');
        }
    }