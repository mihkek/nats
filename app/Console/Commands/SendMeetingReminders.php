<?PHP
/*

Запус данного файла из крона:
/opt/php73/bin/php /var/www/getlaw/data/www/getlaw.ru/artisan currency:update

*/

namespace App\Console\Commands;
use App\Customer;
use App\DirectoryPerson;
use App\Mail\OrdererMeetingReminder;
use App\Models\OrdererZoomConference;
use App\Orderer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMeetingReminders extends Command {

	//The name and signature of the console command.
	protected $signature = 'send:reminders';

	//The console command description.
	protected $description = 'Sends meeting reminders';

	public function __construct() {
		parent::__construct();
	}


	public function handle() {
        $time = time();
        $fromTime = date('Y-m-d H:i:s', $time);
        $toTime = date('Y-m-d H:i:s', $time + 600);

        Orderer::$withScopeRestrictions = false;
        Customer::$withScopeRestrictions = false;
        DirectoryPerson::$withScopeRestrictions = false;

        $query = OrdererZoomConference::where('date_time', '>', $fromTime)
            ->where('date_time', '<', $toTime)
            ->where('reminder_sent', null);

        foreach ($query->get() as $conference) {
            $orderer = Orderer::find($conference->orderer_id);

            if ($orderer->customer) {
                $mailable = new OrdererMeetingReminder($orderer, $conference->url_join, 'customer');
                Mail::to($orderer->customer->main_email)->send($mailable);
            }
            if ($orderer->directory_person) {
                $mailable = new OrdererMeetingReminder($orderer, $conference->url_start, 'directory_person');
                Mail::to($orderer->directory_person->main_email)->send($mailable);
            }

            $conference->reminder_sent = date('Y-m-d H:i:s');
            $conference->save();
        }
	}

}