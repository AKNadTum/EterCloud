<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price_stripe_id',
        'server_limit',
        'disk',
        'backups_limit',
        'databases_limit',
        'cpu',
        'memory',
    ];

    protected $casts = [
        'server_limit' => 'integer',
        'disk' => 'integer',
        'backups_limit' => 'integer',
        'databases_limit' => 'integer',
        'cpu' => 'integer',
        'memory' => 'integer',
    ];

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'location_plan');
    }

    /**
     * Retourne la liste des caractéristiques formatées pour l'affichage.
     */
    public function getFormattedFeatures(): array
    {
        $features = [
            'CPU: ' . ($this->cpu > 0 ? $this->cpu . '%' : 'illimité'),
            'RAM: ' . ($this->memory > 0 ? ($this->memory / 1024) . ' GB' : 'illimitée'),
            'Stockage: ' . ($this->disk / 1024) . ' GB',
            'Instances: ' . $this->server_limit . ' serveur' . ($this->server_limit > 1 ? 's' : ''),
            'Backups: ' . $this->backups_limit,
            'Bases de données: ' . $this->databases_limit,
        ];

        foreach ($this->locations->take(2) as $location) {
            $features[] = 'Localisation: ' . ($location->display_name ?? $location->name ?? $location->ptero_id_location);
        }

        return $features;
    }
}
