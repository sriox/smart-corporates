<?php

namespace App\Exports;

use App\Models\ColorScale;
use App\Models\Operations\PollInstance;
use App\Models\Poll\Dimension;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DemographicEngagementResultsExport implements FromView, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
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
        $data = array_column($data, 'result', 'group_id');
        $groupName = DemographicsMap::getColumnName($this->group);

        $colors = [];
        $groupData = DB::table(Str::plural($this->group, 2))
            ->where('company_id', $pollInstance->company_id)
            ->orderBy('id')
            ->get();

        foreach ($data as $groupId => $result) {
            $colors[$groupId] = $this->getColor($result);
        }

        // foreach ($data as $item) {
        //     $results[$item->dimension_id][$item->group_id] = $item->result;
        //     $colors[$item->dimension_id][$item->group_id] = $this->getColor($item->result);
        // }

        return view('Exports.EngagementResults', compact('groupName', 'data', 'groupData', 'colors'));
    }

    // public function collection()
    // {
    //     $data = DB::select($this->getQuery(), [$this->pollInstanceId]);

    //     $collection = array_map(function ($reg) {
    //         $color = $this->getColor($reg->result);
    //         $row = count(array_keys($this->styles)) + 2;
    //         $this->styles["B{$row}"] = ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $color]]];
    //         return [$reg->group, $reg->result];
    //     }, $data);
    //     return collect($collection);
    // }

    private function getColor(float $val)
    {
        $scale = $this->colors->filter(function ($color) use ($val) {
            return $val > $color->min_val && $val <= $color->max_val;
        })->first();
        $color = isset($scale['color']) ? substr($scale['color'], 1) : 'FFFFFF';
        return $color;
    }

    public function styles(Worksheet $worksheet)
    {
        return $this->styles;
    }

    public function headings(): array
    {
        $colName = DemographicsMap::getColumnName($this->group);

        return [
            $colName,
            'Resultado'
        ];
    }

    private function getQuery()
    {
        $query = str_replace('{{$var}}', $this->group, file_get_contents(app_path('Queries/demographic_engagement_results.sql')));
        return $query;
    }

    public function title(): string
    {
        $colName = DemographicsMap::getColumnName($this->group);
        $title = "Engagement - Resultados por {$colName}";
        return $title;
    }

    // public function columnWidths(): array
    // {
    //     return [
    //         'A' => 55,
    //         'B' => 45,
    //         'C' => 45,
    //     ];
    // }
}
