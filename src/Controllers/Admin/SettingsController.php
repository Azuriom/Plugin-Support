<?php

namespace Azuriom\Plugin\Support\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;

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
        $this->validate($request, [
            'webhook' => ['nullable', 'url'],
        ]);

        Setting::updateSettings([
            'support.webhook' => $request->input('webhook'),
        ]);

        return redirect()->route('support.admin.tickets.index')
            ->with('success', trans('admin.settings.status.updated'));
    }
}
