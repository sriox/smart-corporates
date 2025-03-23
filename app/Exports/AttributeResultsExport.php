<?php

namespace App\Exports;

use App\Models\ColorScale;
use App\Models\Operations\PollInstance;
use App\Models\Poll\Attribute;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttributeResultsExport implements FromView, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    private $group;
    private $pollInstanceId;
    private $styles = [];
    private $colors;

    public function __construct(string $group, int $pollInstanceId)
    {
        $this->group = $group;
        $this->pollInstanceId = $pollInstanceId;
        $this->colors = ColorScale::where('type', 'results')->get();
    }

    public function view(): View
    {
        $pollInstance = PollInstance::find($this->pollInstanceId);

        $data = DB::select($this->getQuery(), [$this->pollInstanceId]);

        $groupData = DB::table(Str::plural($this->group, 2))
            ->where('company_id', $pollInstance->company_id)
            ->orderBy('id')
            ->get();

        $attributes = Attribute::with(['dimension'])->whereHas('dimension', function ($query) {
            return $query->whereHas('poll', function ($query) {
                return $query->whereHas('pollInstances', function ($query) {
                    return $query->where('poll_instances.id', $this->pollInstanceId);
                });
            });
        })
            ->orderBy('order')
            ->get();

        $results = [];
        $colors = [];

        foreach ($data as $item) {
            $results[$item->attribute_id][$item->group_id] = $item->result;
            $colors[$item->attribute_id][$item->group_id] = $this->getColor($item->result);
        }

        return view('Exports.AttributeResults', compact('groupData', 'attributes', 'results', 'colors'));
    }

    public function collection()
    {
        $data = DB::select($this->getQuery(), [$this->pollInstanceId]);
        $collection = collect(array_map(function ($reg) {
            $color = $this->getColor($reg->result);
            $row = count(array_keys($this->styles)) + 2;
            $this->styles["C{$row}"] = ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $color]]];
            return [$reg->group, $reg->attribute_name, $reg->result];
        }, $data));
        return $collection;
    }

    public function styles(Worksheet $worksheet)
    {
        return $this->styles;
    }

    private function getColor(float $val)
    {
        $scale = $this->colors->filter(function ($color) use ($val) {
            return $val > $color->min_val && $val <= $color->max_val;
        })->first();
        $color = isset($scale['color']) ? substr($scale['color'], 1) : 'FFFFFF';
        return $color;
    }

    public function headings(): array
    {
        $colName = DemographicsMap::getColumnName($this->group);

        return [
            $colName,
            'Variable',
            'Resultado'
        ];
    }

    private function getQuery()
    {
        $query = str_replace('{{$var}}', $this->group, file_get_contents(app_path('Queries/attribute_results.sql')));
        return $query;
    }

    public function title(): string
    {
        $colName = DemographicsMap::getColumnName($this->group);
        $title = "Resultados por {$colName} - Variable";
        return $title;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 35,
            'B' => 35,
            'C' => 35,
            'D' => 35,
            'E' => 35,
            'F' => 35,
            'G' => 35,
            'H' => 35,
            'I' => 35,
            'J' => 35,
            'K' => 35,
            'L' => 35,
            'M' => 35,
            'N' => 35,
            'O' => 35,
            'P' => 35,
            'Q' => 35,
            'R' => 35,
            'T' => 35,
            'U' => 35,
            'V' => 35,
            'X' => 35,
            'W' => 35,
            'Y' => 35,
            'Z' => 35,
        ];
    }
}
