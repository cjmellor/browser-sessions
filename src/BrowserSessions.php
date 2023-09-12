<?php

namespace Cjmellor\BrowserSessions;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Jenssegers\Agent\Agent;

class BrowserSessions
{
    public function sessions(): Collection
    {
        if (config(key: 'session.driver') !== 'database') {
            return collect();
        }

        return collect(
            value: DB::connection(config(key: 'session.connection'))->table(table: config(key: 'session.table', default: 'sessions'))
                ->where(column: 'user_id', operator: Auth::user()->getAuthIdentifier())
                ->latest(column: 'last_activity')
                ->get()
        )->map(callback: function ($session): object {
            $agent = $this->createAgent($session);

            return (object) [
                'device' => [
                    'browser' => $agent->browser(),
                    'desktop' => $agent->isDesktop(),
                    'mobile' => $agent->isMobile(),
                    'platform' => $agent->platform(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    protected function createAgent(mixed $session)
    {
        return tap(
            value: new Agent(),
            callback: fn ($agent) => $agent->setUserAgent(userAgent: $session->user_agent)
        );
    }

    public function logoutOtherBrowserSessions(): void
    {
        $password = request()->password;

        if (! Hash::check($password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__(key: 'This password does not match our records.')],
            ]);
        }

        Auth::guard()->logoutOtherDevices($password);

        $this->deleteOtherSessionRecords();
    }

    protected function deleteOtherSessionRecords(): void
    {
        if (config(key: 'session.driver') !== 'database') {
            return;
        }

        DB::connection(config(key: 'session.connection'))->table(table: config(key: 'session.table', default: 'sessions'))
            ->where(column: 'user_id', operator: '=', value: Auth::user()->getAuthIdentifier())
            ->where(column: 'id', operator: '!=', value: request()->session()->getId())
            ->delete();
    }
}
