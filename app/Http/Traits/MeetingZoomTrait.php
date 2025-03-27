<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;

trait MeetingZoomTrait
{
    public function createMeeting($request)
    {
        $accessToken = $this->getZoomAccessToken();

        $meetingData = [
            'topic'      => $request->topic,
            'type'       => 2, // Meeting type (Scheduled meeting)
            'start_time' => $request->start_time,
            'duration'   => $request->duration,
            'timezone'   => 'Asia/Jerusalem',
            'password'   => $request->password ?? '123456',
            'settings'   => [
                'join_before_host'   => false,
                'host_video'         => true,
                'participant_video'  => true,
                'waiting_room'       => true,
            ],
        ];

        $response = Http::withToken($accessToken)
            ->post('https://api.zoom.us/v2/users/me/meetings', $meetingData);

        if ($response->failed()) {
            throw new \Exception('Zoom API Error: ' . $response->body());
        }

        return (object) $response->json();
    }

    public function deleteMeeting($meetingId)
    {
        $accessToken = $this->getZoomAccessToken();

        $response = Http::withToken($accessToken)
            ->delete("https://api.zoom.us/v2/meetings/{$meetingId}");

        if ($response->failed()) {
            throw new \Exception('Zoom API Error: ' . $response->body());
        }

        return true;
    }

    private function getZoomAccessToken()
    {
        $clientId     = env('ZOOM_CLIENT_ID');
        $clientSecret = env('ZOOM_CLIENT_SECRET');
        $accountId    = env('ZOOM_ACCOUNT_ID');

        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'account_credentials',
                'account_id' => $accountId,
            ]);

        if ($response->failed()) {
            throw new \Exception('Failed to get Zoom token: ' . $response->body());
        }

        return $response->json()['access_token'];
    }
}
