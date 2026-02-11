<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingsController extends Controller
{
    /**
     * Display the site settings form.
     */
    public function index()
    {
        $siteName = SiteSetting::get('site_name', 'Apostolado da Oração');
        $siteLogo = SiteSetting::get('site_logo');
        $useLogo = SiteSetting::get('use_logo', '0');
        $logoPosition = SiteSetting::get('logo_position', 'left');
        $favicon = SiteSetting::get('favicon');

        return view('admin.site-settings.index', compact('siteName', 'siteLogo', 'useLogo', 'logoPosition', 'favicon'));
    }

    /**
     * Update the site settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'use_logo' => 'required|in:0,1',
            'logo_position' => 'required|in:left,center,right',
            'site_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|file|mimes:ico,png,jpg,gif|max:1024',
        ]);

        // Update site name
        SiteSetting::set('site_name', $request->site_name);
        
        // Update use_logo setting
        SiteSetting::set('use_logo', $request->use_logo);
        
        // Update logo position
        SiteSetting::set('logo_position', $request->logo_position);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            // Delete old logo if exists
            $oldLogo = SiteSetting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Store new logo
            $logoPath = $request->file('site_logo')->store('logos', 'public');
            SiteSetting::set('site_logo', $logoPath);
        }
        
        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            $oldFavicon = SiteSetting::get('favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }

            // Store new favicon
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            SiteSetting::set('favicon', $faviconPath);
        }

        // Clear all cache
        SiteSetting::clearCache();

        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Configurações do site atualizadas com sucesso!');
    }

    /**
     * Delete the site logo.
     */
    public function deleteLogo()
    {
        $logo = SiteSetting::get('site_logo');
        
        if ($logo && Storage::disk('public')->exists($logo)) {
            Storage::disk('public')->delete($logo);
        }

        SiteSetting::set('site_logo', null);
        SiteSetting::set('use_logo', '0');
        SiteSetting::clearCache();

        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Logo removida com sucesso!');
    }
    
    /**
     * Delete the favicon.
     */
    public function deleteFavicon()
    {
        $favicon = SiteSetting::get('favicon');
        
        if ($favicon && Storage::disk('public')->exists($favicon)) {
            Storage::disk('public')->delete($favicon);
        }

        SiteSetting::set('favicon', null);
        SiteSetting::clearCache();

        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Favicon removido com sucesso!');
    }
}
