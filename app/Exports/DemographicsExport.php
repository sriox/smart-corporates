<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DemographicsExport implements WithMultipleSheets
{

    public $group;
    public $pollInstanceId;


    public function __construct(string $group, int $pollInstanceId)
    {
        $this->group = $group;
        $this->pollInstanceId = $pollInstanceId;
    }


    public function sheets(): array
    {
        return [
            new DemographicEngagementResultsExport($this->group, $this->pollInstanceId),
            new DemographicEngagementDeviationExport($this->group, $this->pollInstanceId),
            new DimensionResultsExport($this->group, $this->pollInstanceId),
            new AttributeResultsExport($this->group, $this->pollInstanceId),
            new VariableResultsExport($this->group, $this->pollInstanceId),
            new DemographicDimensionDeviationExport($this->group, $this->pollInstanceId),
            new DemographicAttributeDeviationExport($this->group, $this->pollInstanceId),
            new DemographicVariableDeviationExport($this->group, $this->pollInstanceId),
        ];
    }
}
