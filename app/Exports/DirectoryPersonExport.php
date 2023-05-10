<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
	
class DirectoryPersonExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithCustomValueBinder
{

    public function __construct($people)
    {
        $this->people = $people;
    }

    public function query()
    {
        $people = $this->people;
        return $people;
    }

    public function map($people): array
	{
        return [
			$people->id,
			
			date("d.m.Y", strtotime($people->created_at)),
			$people->company_name,
			$people->company_inn,
			$people->company_ogrn,
			$people->company_bank_account,
			$people->company_correspondent_account,
			$people->company_bank_bik,
			$people->company_warehouse_address,
			$people->company_web_site,
			$people->company_description,
			$people->company_check_file,
			$people->phone,
			$people->email,
			$people->last_name,
			$people->first_name,
			$people->middle_name,
			($people->confirm == 'on' ? 'да' : '–'),
			($people->deleted == 'on' ? 'удален' : '–'),
			date("d.m.Y", strtotime($people->updated_at)),
		];
	}
	
	public function headings(): array
    {
        return [
            'ID',
			'Зарегистрирован',
			'Компания',
			'ИНН',
			'ОГРН',
			'рас./счет',
			'кор./счет',
			'БИК',
			'Склад (осн.)',
			'Сайт',
			'Описание',
			'Проверка',
			'Телефон',
			'E-mail',
			'Фамилия',
			'Имя',
			'Отчество',
			'Заходил',
			'Удален',
			'Обновлен'
        ];
    }
/*	
	public function collection()
    {
        return $this->customers->get();
    }
*/
}
