<?php /** @noinspection ALL */

namespace App\Services\Transaction\Report;

use App\Models\Transaction\Report;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction\ReportField;

class ReportFieldService
{
    private Report $report;

    public function setReport(Report $report)
    {
        $this->report = $report;
        return $this;
    }

    public function buildFromReportFieldsData(array $reportData): void
    {
        if (!$this->report) {
            return;
        }

        DB::transaction(function() use ($reportData) {
            foreach ($reportData as $key => $value) {
                $this->buildWithChildren($key, $value);
            }
        });
    }

    public function buildWithChildren(string $key, mixed $value, ?ReportField $parentReportField = null): void
    {
        if (!$this->report) {
            return;
        }

        if (is_string($value)) {
            $this->buildAsString($key, $value, $parentReportField);
        }

        if (is_numeric($value)) {
            $this->buildAsNumeric($key, $value, $parentReportField);
        }

        if (is_array($value)) {
            $this->buildAsObject($key, $value, $parentReportField);
        }
    }

    private function buildAsObject(string $key, mixed $value, ?ReportField $parentReportField = null): void
    {
        foreach ($value as $nextLevelKey => $nextLevelValue) {
            $reportField = ReportField::create([
                'name' => $key,
                'type' => ReportField::TYPE_OBJECT,
                'report_id' => $this->report->id,
                'parent_report_field_id' => $parentReportField?->id
            ]);

            $this->buildWithChildren($nextLevelKey, $nextLevelValue, $reportField);
        }
    }

    private function buildAsString(string $key, mixed $value, ?ReportField $parentReportField = null): void
    {
        ReportField::create([
            'name' => $key,
            'type' => ReportField::TYPE_STRING,
            'value' => (string) $value,
            'report_id' => $this->report->id,
            'parent_report_field_id' => $parentReportField?->id
        ]);
    }

    private function buildAsNumeric(string $key, mixed $value, ?ReportField $parentReportField = null): void
    {
        ReportField::create([
            'name' => $key,
            'type' => ReportField::TYPE_NUMERIC,
            'value' => (string) $value,
            'report_id' => $this->report->id,
            'parent_report_field_id' => $parentReportField?->id
        ]);
    }
}
