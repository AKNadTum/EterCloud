<?php

namespace Tests\Feature;

use App\Services\Pterodactyl\PterodactylNodes;
use Illuminate\Support\Facades\Cache;
use Mockery\MockInterface;
use Tests\TestCase;

class StatusPageTest extends TestCase
{
    public function test_status_page_is_accessible(): void
    {
        $this->mock(PterodactylNodes::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')
                ->once()
                ->andReturn([
                    'data' => [
                        [
                            'attributes' => [
                                'name' => 'Node 1',
                                'maintenance_mode' => false,
                                'memory' => 8192,
                                'disk' => 51200,
                                'cpu' => 800,
                                'fqdn' => 'node1.test.com',
                                'allocated_resources' => [
                                    'memory' => 2048,
                                    'disk' => 10240,
                                    'cpu' => 200,
                                ],
                                'relationships' => [
                                    'location' => [
                                        'attributes' => [
                                            'short' => 'FR',
                                            'long' => 'France',
                                        ]
                                    ],
                                    'servers' => [
                                        'meta' => [
                                            'pagination' => [
                                                'total' => 5
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);
        });

        Cache::forget('infrastructure_status');

        $response = $this->get(route('status'));

        $response->assertStatus(200);
        $response->assertSee('infrastructure');
        $response->assertSee('Node 1');
        $response->assertSee('France');
        $response->assertSee('5 serveurs');
        $response->assertSee('Opérationnel');

        // Nouvelles assertions
        $response->assertSee('Nodes Actifs');
        $response->assertDontSee('RAM Allouée');
        $response->assertSee('50GB Stockage');
        $response->assertSee('CPU');
        $response->assertSee('Stockage');
        $response->assertDontSee('GB RAM');
        $response->assertSee('Disque Occupé');
        $response->assertSee('Services');
        $response->assertSee('Panel Pterodactyl');
        $response->assertSee('Historique des incidents');
    }

    public function test_status_page_handles_servers_without_pagination_meta(): void
    {
        $this->mock(PterodactylNodes::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')
                ->once()
                ->andReturn([
                    'data' => [
                        [
                            'attributes' => [
                                'name' => 'Node 2',
                                'maintenance_mode' => false,
                                'memory' => 8192,
                                'disk' => 51200,
                                'cpu' => 800,
                                'fqdn' => 'node2.test.com',
                                'allocated_resources' => [
                                    'memory' => 2048,
                                    'disk' => 10240,
                                    'cpu' => 200,
                                ],
                                'relationships' => [
                                    'location' => [
                                        'attributes' => [
                                            'short' => 'US',
                                            'long' => 'USA',
                                        ]
                                    ],
                                    'servers' => [
                                        'data' => [
                                            ['attributes' => ['uuid' => '1']],
                                            ['attributes' => ['uuid' => '2']],
                                        ]
                                        // Pas de meta pagination ici
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);
        });

        Cache::forget('infrastructure_status');

        $response = $this->get(route('status'));

        $response->assertStatus(200);
        $response->assertSee('2 serveurs');
    }

    public function test_status_page_handles_api_error(): void
    {
        $this->mock(PterodactylNodes::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')
                ->once()
                ->andThrow(new \Exception('API Error'));
        });

        Cache::forget('infrastructure_status');

        $response = $this->get(route('status'));

        $response->assertStatus(200);
        $response->assertSee('Impossible de récupérer l\'état de l\'infrastructure pour le moment.');
    }

    public function test_status_page_handles_missing_cpu_key(): void
    {
        $this->mock(PterodactylNodes::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')
                ->once()
                ->andReturn([
                    'data' => [
                        [
                            'attributes' => [
                                'name' => 'Node Missing CPU',
                                'maintenance_mode' => false,
                                'disk' => 51200,
                                // 'cpu' is missing
                                'fqdn' => 'missing-cpu.test.com',
                                'allocated_resources' => [
                                    'disk' => 10240,
                                    // 'cpu' is missing
                                ],
                                'relationships' => [
                                    'location' => [
                                        'attributes' => [
                                            'short' => 'FR',
                                            'long' => 'France',
                                        ]
                                    ],
                                    'servers' => [
                                        'data' => []
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);
        });

        Cache::forget('infrastructure_status');

        $response = $this->get(route('status'));

        $response->assertStatus(200);
        $response->assertSee('Node Missing CPU');
        $response->assertSee('Illimité');
    }
}
