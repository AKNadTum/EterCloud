<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

class PlanService
{
    public function getAllPlans(): Collection
    {
        return Plan::with('locations')->get();
    }

    public function getPlanById(int $id): ?Plan
    {
        return Plan::with('locations')->find($id);
    }

    public function createPlan(array $data): Plan
    {
        return Plan::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price_stripe_id' => $data['price_stripe_id'],
            'server_limit' => $data['server_limit'] ?? 0,
        ]);
    }

    public function updatePlan(int $id, array $data): ?Plan
    {
        $plan = $this->getPlanById($id);

        if (!$plan) {
            return null;
        }

        $plan->update([
            'name' => $data['name'] ?? $plan->name,
            'description' => $data['description'] ?? $plan->description,
            'price_stripe_id' => $data['price_stripe_id'] ?? $plan->price_stripe_id,
            'server_limit' => $data['server_limit'] ?? $plan->server_limit,
        ]);

        return $plan->fresh();
    }

    public function deletePlan(int $id): bool
    {
        $plan = $this->getPlanById($id);

        if (!$plan) {
            return false;
        }

        return $plan->delete();
    }

    public function getPlanLocations(int $planId): Collection
    {
        $plan = Plan::with('locations')->find($planId);
        if (!$plan) {
            return Location::query()->whereRaw('1 = 0')->get();
        }
        return $plan->locations;
    }

}
