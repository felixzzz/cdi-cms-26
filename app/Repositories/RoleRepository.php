<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class RoleRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function datatable($perPage = 10)
    {
        $search = request('search');
        return Role::query()
        ->where(function ($q) use ($search) {
            $q->where("name", "LIKE", "%$search%");
        })
        ->datatable($perPage, "created_at");
    }

    public function list()
    {
        return Role::query()
        ->orderBy("name", "ASC")->get();
    }

    /**
     * Fetch dynamic permissions from Laravel routes.
     *
     * @return array
     */
    public function getDynamicPermissions()
    {
        $routes = Route::getRoutes()->getRoutes();
        $groupedPermissions = [];

        foreach ($routes as $route) {

            if ($name = $route->getName()) {
                if (Str::startsWith($name, 'admin.')) {
                    if (!in_array($name, ['admin.', 'admin.login', 'admin.logout', 'admin.dashboard'])) {
                        $action = $this->inferActionFromRoute($route);
                        $parts = explode('.', str_replace('admin.', '', $name)); // e.g., ['halo', 'routes', 'index']
                        array_pop($parts); // Remove last segment (e.g., 'index')
                        $resource = implode('.', $parts); // e.g., "halo.routes"
                        $permission = "$action $resource"; // e.g., "view halo.routes"
                        $groupedPermissions[Str::title(str_replace(".", " ", $resource))][] = $permission;
                    }
                }
            }
        }

        // Remove duplicates within each group and sort
        foreach ($groupedPermissions as $resource => &$permissions) {
            $permissions = array_unique($permissions);
            sort($permissions);
        }

        return $groupedPermissions;
    }

    /**
     * Infer CRUD action from route method or URI.
     *
     * @param \Illuminate\Routing\Route $route
     * @return string
     */
    protected function inferActionFromRoute($route)
    {
        $method = strtolower($route->methods()[0]); // e.g., GET, POST
        $uri = $route->uri();

        if ($method === 'get' && Str::endsWith($uri, ['index', 'show', '/'])) {
            return 'view';
        } elseif ($method === 'post' || Str::endsWith($uri, 'store')) {
            return 'add';
        } elseif ($method === 'put' || $method === 'patch' || Str::endsWith($uri, 'update')) {
            return 'edit';
        } elseif ($method === 'delete' || Str::endsWith($uri, 'destroy')) {
            return 'delete';
        }

        return 'view'; // Default fallback
    }
}
