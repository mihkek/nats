<?php

namespace App\Exports;

use App\Models\ConfigerUsers;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
	
class ConfigerExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithCustomValueBinder
{

	public $roles = [
			101 => 'Покупатель',
			102 => 'Поставщик',
			1000 => 'Админ'
	];
	
    public function __construct($configers)
    {
        $this->configers = $configers;
    }

    public function query()
    {
        $configers = $this->configers;
        return $configers;
    }

    public function map($configers): array
	{
        return [
			$configers->id,
			$this->setrole($configers->role_id),
			$configers->last_name,
			$configers->first_name,
			$configers->middle_name,
			$configers->phone,
			$configers->email,
			$configers->company_name,
			$configers->company_inn,
			$configers->company_ogrn,
			$configers->company_bank_account,
			$configers->company_correspondent_account,
			$configers->company_bank_bik,
			$configers->company_warehouse_address,
			$configers->company_web_site,
			$configers->company_description,
			$configers->company_check_file,
			date("d.m.Y", strtotime($configers->created_at)),
			date("d.m.Y", strtotime($configers->updated_at)),
			($configers->confirm == 'on' ? 'да' : '–'),
			($configers->deleted == 'on' ? 'удален' : '–'),
		];
	}
	
	public function setrole($role_id) {
		return $this->roles[$role_id];
		return $role_id+1;
	}

	public function headings(): array
    {
        return [
            'ID',
            'Роль',
			'Фамилия',
			'Имя',
			'Отчество',
			'Телефон',
			'E-mail',
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
			'Создан',
			'Обновлен',
			'Заходил',
			'Удален',
        ];
    }
	/**
    * @return \Illuminate\Support\Collection
    */
/*
	public function collection()
    {
        return $this->configers->get();
    }
*/
}
