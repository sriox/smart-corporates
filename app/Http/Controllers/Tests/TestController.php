<?php

namespace App\Http\Controllers\Tests;

use App\Exports\AttributeResultsExport;
use App\Exports\DemographicAttributeDeviationExport;
use App\Exports\DemographicDimensionDeviationExport;
use App\Exports\DemographicEngagementDeviationExport;
use App\Exports\DemographicEngagementResultsExport;
use App\Exports\DemographicsExport;
use App\Exports\DemographicsMap;
use App\Exports\DemographicVariableDeviationExport;
use App\Exports\DimensionResultsExport;
use App\Exports\VariableResultsExport;
use App\Http\Controllers\Controller;
use App\Models\Company\Participant;
use App\Models\Company\Person;
use App\Models\Operations\ParticipantPollAnswer;
use App\Models\Operations\PollInstance;
use App\Models\Poll\Attribute;
use App\Models\Poll\Dimension;
use App\Models\Poll\ParticipantWord;
use App\Models\Poll\PollAnswer;
use App\Models\Poll\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class TestController extends Controller
{
    public function index()
    {
        $var = 'age_range';
        $name = DemographicsMap::getColumnName($var);
        $export = new DemographicEngagementDeviationExport($var, 4);
        return \Excel::download($export, "{$name}.xlsx", \Maatwebsite\Excel\Excel::XLSX);
    }

    private function getQuery($var)
    {
        $query = str_replace('{{$var}}', $var, file_get_contents(app_path('queries/dimension_results.sql')));
        return $query;
    }
}
