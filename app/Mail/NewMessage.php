<?php

    namespace App\Mail;

    use App\Models\User;
    use App\Auction;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Config;

    class NewMessage extends Mailable
    {
        use Queueable, SerializesModels;

        /**
         * The order instance.
         *
         * @var User
         */

        public $message_text;
        public $auction_id;
        public $auction_title;
        public $link_card;    
        public $subject;

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct($message_text, $auction_id, $auction_title, $link_card, $subject)
        {
            $this->message_text = $message_text;
            $this->auction_id = $auction_id;
            $this->auction_title = $auction_title;
            $this->link_card = $link_card;
            $subject .= ' - ' . Config('global.project.title0');
            $this->subject = $subject;         
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
                ->view('emails.new_message');
        }
    }