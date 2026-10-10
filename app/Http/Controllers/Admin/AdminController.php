<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Cache;

class AdminController extends Controller
{
    public function admin_dashboard(Request $request)
    {


        // E-commerce KPI metrics
        $total_customers = \App\Models\User::where('user_type', 'customer')->count();
        $today_customers = \App\Models\User::where('user_type', 'customer')->where('created_at', '>=', \Carbon\Carbon::today())->count();
        $this_month_customers = \App\Models\User::where('user_type', 'customer')->where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->count();


        // Monthly Sales Trend for past 12 months
        $sales_trend_months = [];
        for ($i = 11; $i >= 0; $i--) {
            $month_start = strtotime("first day of -$i month 00:00:00");
            $month_end = strtotime("last day of -$i month 23:59:59");
            $sales_trend_months[] = date('M Y', $month_start);

        }


        return view('backend.dashboard', compact(
            'total_customers',
            'today_customers',
            'this_month_customers',
            'sales_trend_months',
        ));
    }

    function clearCache(Request $request)
    {
        Artisan::call('cache:clear');
        $keys = [
            'footer_categories',
            'footer_services',
            'business_settings',
            'categoriesTree',
            'header_categories',
            'header_brands',
            'homeSlider',
            'home_categories',
            'home_products',
            'home_products',
            'home_services',
            'home_testimonials',
            'home_blogs',
            'brandsWithCount'
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        Cache::flush();

        flash(trans('messages.cache_cleared_successfully'))->success();
        return back();
    }
}
