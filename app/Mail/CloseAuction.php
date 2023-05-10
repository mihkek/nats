<?php

    namespace App\Mail;

    use App\Models\User;
    use App\Auction;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Config;

    class CloseAuction extends Mailable
    {
        use Queueable, SerializesModels;

        /**
         * The order instance.
         *
         * @var User
         */
        public $auction;
        public $rate;
        public $customer;
        public $supplier;
        public $conferenceUrl;
        public $subject = 'Тендер завершен';

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct(Auction $auction, $rate, $customer, $supplier, $conferenceUrl)
        {
            $this->auction = $auction;
            $this->rate = $rate;
            $this->customer = $customer;
            $this->supplier = $supplier;
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
                ->view('emails.close_auction');
        }
    }