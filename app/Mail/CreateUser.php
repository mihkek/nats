<?php

    namespace App\Mail;

    use App\Models\User;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Config;

    class CreateUser extends Mailable
    {
        use Queueable, SerializesModels;

        /**
         * The order instance.
         *
         * @var User
         */
        public $user;
        public $emailTo;
        public $subject = 'Доступ к системе';
        public $plainPassword;

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct($email, $plainPassword = '')
        {
            $this->emailTo = $email;
            $this->plainPassword = $plainPassword;
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
                ->view('admin.configer.create_user_email');
        }
    }