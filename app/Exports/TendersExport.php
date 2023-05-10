<?php

namespace App\Exports;

use App\Models\User;

// use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Auction;
use App\AuctionRate;

class TendersExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithCustomValueBinder, WithEvents //FromQuery
{

	public $states = [
		0 => 'Отменен',
		1 => 'Активный',
		2 => 'Завершен'
	];

	public $delivery_conditions = [
		1 => 'Со склада поставщика',
		2 => 'Поставка на мой склад',
		3 => 'Транспортной компанией до терминала'
	];

	public $payment_conditions = [
        1 => 'В течение 5 дней после поставки',
        2 => 'Через 30 дней после доставки',
        3 => 'Через 60 дней после доставки',
        4 => 'Через 90 дней после доставки',
        5 => 'Предоплата',
	];
	

    public function __construct($tenders)
    {
        $this->tenders = $tenders;
		$this->tendercount = 1;
    }

	public function collection()
    {
		$tenders = $this->tenders;
		$tenders = $tenders->get();



		foreach ($tenders as $tender) {
			$user = User::find($tender->user_id);
			$tender->user = $user->company_name." (".$tender->user_id.")";

			$tender->inn = $user->company_inn;
			
			$rate = AuctionRate::where('auction_id', $tender->id)->whereIn('status', [1,2])->where('deleted', '')->orderBy('price')->first();
            $tender->rate = !empty($rate) ? $rate->price.' ₽/'.$tender->unit : '–' ;
            $tender->summ = !empty($rate) ? ($rate->price*$tender->size).' ₽' : '–' ;

			$win_rate = AuctionRate::where('id', $tender->win_rate_id)->whereIn('status', [2])->where('deleted', '')->first();
			if (!empty($win_rate)) {
				$winner = User::find($win_rate->user_id);
				$tender->winner = $winner->company_name." (".$winner->id.")";
				$tender->rate = $tender->rate." ★";
			}
			else {
				$tender->winner = '–';
			}

			$allrates = '';
			$sep = '';
            foreach ($tender->rates as $rate) {
				if ($seller = User::find($rate->user_id)) $company_name = $seller->company_name;
				else $company_name = '???';

				/*$allrates = $rate->price.' ₽/'.$tender->unit." – ".$company_name." (".$rate->user_id.")".$sep.$allrates;*/
				
				$allratesitem = $rate->price.' ₽/'.$tender->unit." – ".$company_name." (".$rate->user_id.")";

				if (isset($rate->is_analog) && isset($rate->analog_name) &&  ($rate->is_analog === 1)) {
					$allratesitem = $allratesitem .' (аналог '. $rate->analog_name .')';
				}

				$allrates = $allratesitem.$sep.$allrates;
				$sep = "\r\n";
            }
			$tender->allrates = $allrates ? $allrates : '–';
			$this->tendercount = $this->tendercount+1;
		}

        return $tenders;
    }

	
	public function map($tenders): array
	{
        return [
			$tenders->id,
			$tenders->user,

			$tenders->inn,

			$tenders->title,
			$tenders->active_material,
			($tenders->is_analog > 0 ? 'да' : '–'),
			$tenders->size,
			$tenders->unit,
			$tenders->rate,
			$tenders->summ,
			$tenders->allrates,
			
			date("d.m.Y", strtotime($tenders->over_date)),
			date("d.m.Y", strtotime($tenders->delivery_date)),
			
			$this->delivery_conditions[$tenders->delivery_condition],
			$tenders->delivery_region,            
            !empty($tenders->payment_condition)?$tenders->payment_condition:'-', //array_key_exists($tenders->payment_condition,$this->payment_conditions)?$this->payment_conditions[$tenders->payment_condition]:'-',
			$tenders->special_terms,
			$this->states[$tenders->status],
			($tenders->customer_confirm > 0 ? 'да' : '–'),
			($tenders->supplier_confirm > 0 ? 'да' : '–'),
			$tenders->winner,
			date("d.m.Y", strtotime($tenders->created_at)),
            date("d.m.Y", strtotime($tenders->updated_at)),            
		];
	}

	public function headings(): array
    {
        return [
					'№ тендера',  //ID
					'Покупатель',
					'ИНН',
					'Наименование',
					'Действующее вещество',
					'Можно аналоги',
					'Объем',
					'ед.изм.',
					'Тек. ставка',
					'Сумма',
					'Все ставки',
					'Дата окончания',
					'Дата поставки',
					'Условия поставки',
					'Регион поставки',
					'Условия оплаты',
					'Особые условия',
					'Статус',
					'Подписано покупателем',
					'Подписано поставщиком',
					'Победитель',
					'Создан',
					'Изменен',					
		];
    }

	
public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:Z1')->getFont()->setBold(true);
				$event->sheet->getDelegate()->getStyle('J1:J'.$this->tendercount)->getAlignment()->setWrapText(true);
				$event->sheet->getDelegate()->getStyle('A1:Z'.$this->tendercount)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            },
        ];
    }
}
