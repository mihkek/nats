<?php

namespace App\Exports;

use App\Models\User;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Message;

class MessagesExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithCustomValueBinder 
{


    public function __construct($messages)
    {
        $this->messages = $messages;
    }

	public function collection()
    {
		$messages = $this->messages;
        return $messages;
    }

	
	public function map($messages): array
	{
        return [
			$messages->id,
			date("d.m.Y H:i", strtotime($messages->created_at)),
			$messages->auction_id,
			$messages->name,
			$messages->message,					
         
		];
	}

	public function headings(): array
    {
        return [
					'ID',
					'Дата',
					'Тендер',
					'Имя',
					'Сообщение',									
		];
    }


}
