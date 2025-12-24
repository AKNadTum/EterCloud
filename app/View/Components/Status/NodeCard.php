<?php

namespace App\View\Components\Status;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NodeCard extends Component
{
    public array $node;
    public string $name;
    public string $locationLong;
    public string $locationShort;
    public string $fqdn;
    public bool $isMaintenance;
    public int $totalServers;
    public float $diskPercent;
    public int $diskTotal;
    public float $cpuPercent;
    public bool $isCpuUnlimited;

    /**
     * Create a new component instance.
     */
    public function __construct(array $node)
    {
        $this->node = $node;
        $this->processAttributes();
    }

    protected function processAttributes(): void
    {
        $attr = $this->node['attributes'] ?? [];
        $location = $attr['relationships']['location']['attributes'] ?? ['short' => 'Unknown', 'long' => 'Unknown'];

        $this->name = $attr['name'] ?? 'Unknown Node';
        $this->locationLong = $location['long'];
        $this->locationShort = $location['short'];
        $this->fqdn = $attr['fqdn'] ?? 'N/A';
        $this->isMaintenance = (bool) ($attr['maintenance_mode'] ?? false);

        // Calcul du nombre de serveurs
        $serversRel = $attr['relationships']['servers'] ?? null;
        $this->totalServers = $serversRel ? ($serversRel['meta']['pagination']['total'] ?? count($serversRel['data'] ?? [])) : 0;

        // Calcul Stockage
        $diskUsed = $attr['allocated_resources']['disk'] ?? 0;
        $this->diskTotal = $attr['disk'] ?? 0;
        $this->diskPercent = ($this->diskTotal > 0) ? min(($diskUsed / $this->diskTotal) * 100, 100) : 0;

        // Calcul CPU
        $cpuUsed = $attr['allocated_resources']['cpu'] ?? 0;
        $cpuTotal = $attr['cpu'] ?? 0;
        $this->isCpuUnlimited = $cpuTotal <= 0;
        $this->cpuPercent = !$this->isCpuUnlimited ? min(($cpuUsed / $cpuTotal) * 100, 100) : 0;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.status.node-card');
    }
}
