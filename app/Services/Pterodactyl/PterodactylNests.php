<?php

namespace App\Services\Pterodactyl;

/**
 * Pterodactyl Application API — Nests & Eggs endpoints.
 * Docs: /api/application/nests
 */
class PterodactylNests
{
    public function __construct(private readonly PterodactylApplication $api)
    {
    }

    // Nests
    public function list(array $query = []): array
    {
        return $this->api->get('/nests', $query);
    }

    public function get(int $nestId, array $query = []): array
    {
        return $this->api->get("/nests/{$nestId}", $query);
    }

    // Eggs within a nest
    public function eggs(int $nestId, array $query = []): array
    {
        return $this->api->get("/nests/{$nestId}/eggs", $query);
    }

    public function egg(int $nestId, int $eggId, bool $includeVariables = false): array
    {
        $query = $includeVariables ? ['include' => 'variables'] : [];
        return $this->api->get("/nests/{$nestId}/eggs/{$eggId}", $query);
    }

    /**
     * Récupère les variables d’un Egg, en tentant plusieurs structures de réponse,
     * et retourne une liste normalisée prête à l’emploi.
     */
    public function getEggVariables(int $nestId, int $eggId): array
    {
        // 1) Tenter avec include=variables
        $egg = $this->egg($nestId, $eggId, true);

        // 1.a relationships au niveau racine
        $relVars = $this->safeArrayGet($egg, 'relationships.variables.data', []);

        // 1.b relationships sous attributes (certains panels)
        if (empty($relVars)) {
            $relVars = $this->safeArrayGet($egg, 'attributes.relationships.variables.data', []);
        }

        // 1.c side-load via top-level included (si jamais)
        if (empty($relVars) && isset($egg['included']) && is_array($egg['included'])) {
            foreach ($egg['included'] as $inc) {
                $type = $inc['object'] ?? ($inc['type'] ?? null);
                if ($type === 'egg_variable') {
                    $relVars[] = $inc; // même structure attendue: attributes
                }
            }
        }

        // 2) Fallback: endpoint dédié quand include ne renvoie rien
        if (empty($relVars)) {
            try {
                $fallback = $this->api->get("/eggs/{$eggId}/variables");
                $relVars = $fallback['data'] ?? [];
            } catch (\Throwable $e) {
                // On retourne un tableau vide si indisponible; pas d’exception bloquante ici
                $relVars = [];
            }
        }

        return $this->normalizeEggVariables($relVars);
    }

    /**
     * Construit un tableau d’environnement par défaut: ['ENV_KEY' => 'default']
     */
    public function getEggEnvironmentDefaults(int $nestId, int $eggId): array
    {
        $vars = $this->getEggVariables($nestId, $eggId);
        $env = [];
        foreach ($vars as $v) {
            $key = (string) ($v['key'] ?? '');
            if ($key !== '') {
                $env[$key] = is_null($v['default']) ? '' : (string) $v['default'];
            }
        }
        return $env;
    }

    // --- Helpers privés ---

    /**
     * Transforme la liste brute (avec clés 'attributes') en format simplifié uniforme.
     */
    private function normalizeEggVariables(array $items): array
    {
        $out = [];
        foreach ($items as $it) {
            $a = $it['attributes'] ?? [];
            $rules = (string) ($a['rules'] ?? '');
            $out[] = [
                'id'            => $a['id'] ?? null,
                'name'          => $a['name'] ?? null,
                'key'           => $a['env_variable'] ?? null,
                'description'   => $a['description'] ?? null,
                'default'       => $a['default_value'] ?? null,
                'required'      => (is_string($rules) && str_contains($rules, 'required')) || (bool)($a['is_required'] ?? false),
                'user_viewable' => (bool)($a['user_viewable'] ?? false),
                'user_editable' => (bool)($a['user_editable'] ?? false),
                'rules'         => $rules,
            ];
        }
        return $out;
    }

    /**
     * Alternative légère à data_get pour éviter la dépendance, reste sûre.
     */
    private function safeArrayGet(array $array, string $path, mixed $default = null): mixed
    {
        $segments = explode('.', $path);
        $current = $array;
        foreach ($segments as $segment) {
            if (!is_array($current) || !array_key_exists($segment, $current)) {
                return $default;
            }
            $current = $current[$segment];
        }
        return $current;
    }
}
