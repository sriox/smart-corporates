<?php

namespace App\Exports;


class DemographicsMap
{
    private static $map = [
        'age_range' => 'Edad',
        'service_time_range' => 'Antiguedad',
        'company_level' => 'Nivel de la organización',
        'area' => 'Área',
        'division' => 'Dirección',
        'gender' => 'Género',
    ];

    public static function getColumnName($group)
    {
        $colName = self::$map[$group] ?? $group;
        return $colName;
    }

    public static function getGroups()
    {
        return array_map(fn ($key) => ['key' => $key, 'label' => self::$map[$key]], array_keys(self::$map));
    }
}
