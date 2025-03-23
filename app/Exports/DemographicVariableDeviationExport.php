<?php


namespace App\Exports;

use App\Models\Operations\PollInstance;
use App\Models\Poll\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class DemographicVariableDeviationExport implements FromView, WithHeadings, ShouldAutoSize, WithTitle
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

        $questions = Question::with(['attribute', 'attribute.dimension'])->where('poll_id', $pollInstance->poll_id)
            ->whereNull('question_group_id')
            ->orderBy('order')
            ->get();

        $results = [];

        foreach ($data as $item) {
            $results[$item->question_id][$item->group_id] = $item->deviation;
        }
        return view('Exports.VariableDeviationResults', compact('groupData', 'questions', 'results'));
    }

    public function collection()
    {
        $data = DB::select($this->getQuery(), [$this->pollInstanceId]);

        $collection = collect(array_map(fn ($reg) => [$reg->group, $reg->variable, $reg->deviation], $data));
        return $collection;
    }

    public function headings(): array
    {
        $colName = DemographicsMap::getColumnName($this->group);
        return [
            $colName,
            'Indicador',
            'Desviación'
        ];
    }

    private function getQuery()
    {
        return str_replace('{{$var}}', $this->group, file_get_contents(app_path('Queries/demographic_variable_deviation.sql')));
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
        $title = "Desviación por {$colName} - Indicador";
        return $title;
    }
}
