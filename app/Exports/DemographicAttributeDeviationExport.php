<?php


namespace App\Exports;

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
use Maatwebsite\Excel\Concerns\WithTitle;

class DemographicAttributeDeviationExport implements FromView, WithHeadings, ShouldAutoSize, WithTitle
{

    public function __construct(private string $group, private int $pollInstanceId)
    {
        $this->group = $group;
        $this->pollInstanceId = $pollInstanceId;
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
            $results[$item->attribute_id][$item->group_id] = $item->deviation;
        }

        return view('Exports.AttributeDeviationResults', compact('groupData', 'attributes', 'results'));
    }

    public function collection()
    {
        $data = DB::select($this->getQuery(), [$this->pollInstanceId]);

        $collection = collect(array_map(fn ($reg) => [$reg->group, $reg->attribute, $reg->deviation], $data));
        return $collection;
    }

    public function headings(): array
    {
        $colName = DemographicsMap::getColumnName($this->group);
        return [
            $colName,
            'Variable',
            'Desviación'
        ];
    }

    private function getQuery()
    {
        return str_replace('{{$var}}', $this->group, file_get_contents(app_path('Queries/demographic_attribute_deviation.sql')));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 35,
            'C' => 20
        ];
    }

    public function title(): string
    {
        $colName = DemographicsMap::getColumnName($this->group);
        $title = "Desviación por {$colName} - Variable";
        return $title;
    }
}
