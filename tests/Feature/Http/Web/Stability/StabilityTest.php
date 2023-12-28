<?php

namespace Tests\Feature\Http\Web\Stability;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class StabilityTest extends TestCase
{
    public function test_all_routes_return_non_error_statuses(): void
    {
        // Really basic 'stability' test which is checking if
        // web routes with GET method and 0 parameters are returning
        // ok (200) or redirect (302) statuses.
        // Should not be considered as
        // final indicator of application's health

        $admin = User::factory()->admin()->create();

        foreach (self::getWebRoutes() as $routeLabel => $webRouteData) {
            // Reject some routes (vendor packages / configuration / other excluded routes)
            if (self::routeShouldNotBeTested($webRouteData['uri'])) {
                continue;
            }

            if (in_array('GET', $webRouteData['methods'])) {
                $response = $this
                    ->actingAs($admin)
                    ->get($webRouteData['uri']);

                $this->assertContains(
                    $response->getStatusCode(),
                    [200, 302],
                    'Test for ' . $routeLabel
                );
            }
        }
    }

    private static function routeShouldNotBeTested(string $uri): bool
    {
        return
            str_contains($uri, 'horizon') ||
            str_contains($uri, 'csrf-cookie') ||
            str_contains($uri, 'log-viewer') ||
            str_contains($uri, '_ignition') ||
            str_contains($uri, '_debugbar') ||
            str_contains($uri, 'telescope') ||
            (str_contains($uri, '{') && str_contains($uri, '}'));
    }

    private static function getWebRoutes(): array
    {
        // Data provider cannot be used, as we cannot
        // call facades outside of application's context
        $webRoutes = [];

        foreach (Route::getRoutes() as $route) {
            if (in_array('web', $route->middleware())) {
                $webRoutes["[$route->uri]"] = [
                    'uri' => $route->uri,
                    'methods' => $route->methods,
                    'middleware' => $route->middleware()
                ];
            }
        }

        return $webRoutes;
    }
}
