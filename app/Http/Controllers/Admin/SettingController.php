<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    public function index()
    {
        $groups = Setting::orderBy('group')->orderBy('sort_order')->get()->groupBy('group');
        return view('admin.settings.index', compact('groups'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token', '_method']);

        foreach ($inputs as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if (!$setting) continue;
            if ($setting->type === 'password' && empty($value)) continue;

            $storeValue = $setting->is_encrypted
                ? Crypt::encryptString((string) $value)
                : (string) $value;

            $setting->update(['value' => $storeValue]);
        }

        return back()->with('success', 'Settings saved successfully.');
    }

    public function store(Request $request)
    {
        // Resolve group — use group_new if __new__ was selected
        $group = $request->group === '__new__'
            ? strtolower(trim($request->group_new))
            : $request->group;

        $request->validate([
            'key'          => 'required|string|unique:settings,key|regex:/^[a-z0-9_]+$/',
            'label'        => 'required|string|max:100',
            'type'         => 'required|in:text,password,textarea',
            'value'        => 'nullable|string',
            'description'  => 'nullable|string|max:255',
            'is_encrypted' => 'boolean',
            'sort_order'   => 'integer|min:0',
        ]);

        // Validate group_new if needed
        if ($request->group === '__new__') {
            if (empty($group)) {
                return back()->withErrors(['group_new' => 'Group name is required.'])->withInput();
            }
            if (!preg_match('/^[a-z0-9_]+$/', $group)) {
                return back()->withErrors(['group_new' => 'Lowercase letters, numbers, underscores only.'])->withInput();
            }
        }

        $value = $request->value;
        if ($request->boolean('is_encrypted') && $value) {
            $value = Crypt::encryptString($value);
        }

        Setting::create([
            'key'          => $request->key,
            'label'        => $request->label,
            'group'        => $group,          // ← resolved group
            'type'         => $request->type,
            'value'        => $value,
            'description'  => $request->description,
            'is_encrypted' => $request->boolean('is_encrypted'),
            'sort_order'   => $request->sort_order ?? 0,
        ]);

        return back()->with('success', "Setting '{$request->label}' created.");
    }

    public function destroy(Setting $setting)
    {
        $label = $setting->label;
        $setting->delete();
        return back()->with('success', "Setting '{$label}' deleted.");
    }

    public function testMail(Request $request)
    {
        $request->validate(['test_email' => 'required|email']);

        try {
            Mail::raw('This is a test email from your NEMT app settings.', function ($msg) use ($request) {
                $msg->to($request->test_email)->subject('Test Email — MedRide');
            });
            return back()->with('success', 'Test email sent to ' . $request->test_email);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed: ' . $e->getMessage());
        }
    }
}
