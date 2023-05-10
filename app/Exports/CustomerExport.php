<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
	
class CustomerExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithCustomValueBinder
{

    public function __construct($customers)
    {
        $this->customers = $customers;
    }

    public function query()
    {
        $customers = $this->customers;
        return $customers;
    }

    public function map($customers): array
	{
        return [
			$customers->id,
			date("d.m.Y", strtotime($customers->created_at)),
			$customers->company_name,
			$customers->company_inn,
			$customers->company_ogrn,
			$customers->company_bank_account,
			$customers->company_correspondent_account,
			$customers->company_bank_bik,
			$customers->company_warehouse_address,
			$customers->company_web_site,
			$customers->company_description,
			$customers->company_check_file,
			$customers->phone,
			$customers->email,
			$customers->last_name,
			$customers->first_name,
			$customers->middle_name,
			($customers->confirm == 'on' ? 'да' : '–'),
			($customers->deleted == 'on' ? 'удален' : '–'),
			date("d.m.Y", strtotime($customers->updated_at)),
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
