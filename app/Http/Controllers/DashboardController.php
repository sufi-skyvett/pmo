<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * This controller handles all actions related to the Admin Dashboard
 * for the Snipe-IT Asset Management application.
 *
 * @author A. Gianotto <snipe@snipe.net>
 * @version v1.0
 */
class DashboardController extends Controller
{
    /**
     * Check authorization and display admin dashboard, otherwise display
     * the user's checked-out assets.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function index()
    {
        // Show the page
        if (Auth::user()->hasAccess('admin')) {
            $asset_stats = null;

            $counts['asset'] = \App\Models\Asset::count();
            $counts['accessory'] = \App\Models\Accessory::count();
            $counts['license'] = \App\Models\License::assetcount();
            $counts['consumable'] = \App\Models\Consumable::count();
            $counts['component'] = \App\Models\Component::count();
            $counts['user'] = \App\Models\Company::scopeCompanyables(Auth::user())->count();
            $counts['grand_total'] = $counts['asset'] + $counts['accessory'] + $counts['license'] + $counts['consumable'];

            if ((!file_exists(storage_path() . '/oauth-private.key')) || (!file_exists(storage_path() . '/oauth-public.key'))) {
                Artisan::call('migrate', ['--force' => true]);
                \Artisan::call('passport:install');
            }

            return view('dashboard')->with('asset_stats', $asset_stats)->with('counts', $counts);
        } else {
            // Redirect to the profile page
            // dd(Auth::id());
            $results = DB::table('permission_groups as pg')
                ->select('pg.name')
                ->join('users_groups as ug', 'pg.id', '=', 'ug.group_id')
                ->where('ug.user_id', '=', Auth::id())
                ->first();

            if (str_contains($results->name, 'Project Manager')) {
                // dd($results->name);
                return redirect()->route('projects.index');
            } elseif (str_contains($results->name, 'Helpdesk')) {
                return redirect()->route('projects.index');
            } else {
                // Handle other cases or return default view
            }

            return redirect()->intended('account/view-assets');
        }
    }
}
