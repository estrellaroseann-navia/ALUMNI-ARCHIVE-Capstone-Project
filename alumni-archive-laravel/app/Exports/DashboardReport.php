<?php

namespace App\Exports;

use App\Models\Cluster;
use App\Models\UserProfile;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DashboardReport implements WithMultipleSheets
{
    protected $data;  // The data passed for export

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        // Prepare an array of sheets for each cluster
        $sheets = [];

        foreach ($this->data as $clusterId => $clusterData) {
            $sheets[] = new ClusterSheet($clusterData, $clusterId);  // Add new sheet for each cluster
        }

        return $sheets;
    }
}

class ClusterSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $data;
    protected $clusterId;

    public function __construct($data, $clusterId)
    {
        $this->data = $data;
        $this->clusterId = $clusterId;
    }

    public function collection()
    {
        // Prepare the data collection for the specific cluster
        return collect($this->data);  // Convert to a collection for export
    }

    public function title(): string
    {
        // Return the title for the sheet (cluster name)
        $clusterName = Cluster::find($this->clusterId)->name ?? 'Cluster ' . $this->clusterId;
        return $clusterName;
    }

    public function headings(): array
    {
        return ['Campus', 'Program', 'Total Alumni Count'];
    }
}
