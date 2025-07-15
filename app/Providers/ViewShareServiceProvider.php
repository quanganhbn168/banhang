<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use App\Models\ServiceCategory;
use App\Models\PostCategory;
class ViewShareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->shareServiceCategories();
        $this->sharePostCategories();
    }

    protected function shareServiceCategories(): void
    {
        if (!Schema::hasTable('service_categories')) return;

        $dichvuMenu = Cache::rememberForever('shared_service_categories_menu', function () {
            return ServiceCategory::with(['children' => function ($q) {
                $q->select('id', 'parent_id', 'name', 'slug')
                  ->where('is_menu', 1)
                  ->where('status', 1);
            }])
            ->select('id', 'name', 'slug')
            ->where('is_menu', 1)
            ->where('status', 1)
            ->where('parent_id', 0)
            ->get();
        });

        View::share('dichvuMenu', $dichvuMenu);
    }

    protected function sharePostCategories(): void
    {
        if (!Schema::hasTable('post_categories')) return;

        $postMenu = Cache::rememberForever('shared_post_categories_menu', function () {
            return PostCategory::select('id', 'name', 'slug')
                ->where('is_menu', 1)
                ->where('status', 1)
                ->where('parent_id', 0)
                ->get();
        });

        View::share('postMenu', $postMenu);
    }
}
