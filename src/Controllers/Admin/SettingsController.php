<?php

namespace Azuriom\Plugin\Support\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SettingsController extends Controller
{
    /**
     * Update the vote settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $settings = $this->validate($request, [
            'home' => ['nullable', 'string'],
            'webhook' => ['nullable', 'url'],
            'close_after_days' => ['nullable', 'integer', 'min:1'],
        ]);

        Setting::updateSettings('support.reopen', $request->filled('reopen'));
        Setting::updateSettings(Arr::prependKeysWith($settings, 'support.'));

        return redirect()->route('support.admin.tickets.index')
            ->with('success', trans('admin.settings.updated'));
    }
}
