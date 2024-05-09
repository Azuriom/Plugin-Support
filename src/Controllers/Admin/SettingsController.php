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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $settings = $this->validate($request, [
            'home' => ['nullable', 'string'],
            'tickets_delay' => ['nullable', 'integer', 'min:0'],
            'webhook' => ['nullable', 'url'],
            'close_after_days' => ['nullable', 'integer', 'min:1'],
        ]);

        Setting::updateSettings(array_merge(Arr::prependKeysWith($settings, 'support.'), [
            'support.reopen' => $request->filled('reopen'),
        ]));

        return to_route('support.admin.tickets.index')
            ->with('success', trans('admin.settings.updated'));
    }
}
