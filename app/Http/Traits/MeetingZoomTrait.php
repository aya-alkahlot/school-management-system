<?php

namespace App\Http\Traits;

use Jubaer\Zoom\Facades\Zoom;

use Illuminate\Support\Facades\Http;



trait MeetingZoomTrait
{
    /*
    public function createMeeting($request){


       // $user = Zoom::user()->first();

        $meetingData = [
            'topic' => $request->topic,
            'duration' => $request->duration,
            'password' => $request->password,
            'start_time' => $request->start_time,
            'timezone' => config('zoom.timezone')
          // 'timezone' => 'Africa/Cairo'
        ];
        $meeting = Zoom::meeting()->make($meetingData);

        dd(  $meeting);

        $meeting->settings()->make([
            'join_before_host' => false,
            'host_video' => false,
            'participant_video' => false,
            'mute_upon_entry' => true,
            'waiting_room' => true,
            'approval_type' => config('zoom.approval_type'),
            'audio' => config('zoom.audio'),
            'auto_recording' => config('zoom.auto_recording')
        ]);

        return  $user->meetings()->save($meeting);


    }

    */

    public function createMeeting($request)
    {
        // Step 1: Get Zoom Access Token (OAuth)
        $accessToken = $this->getZoomAccessToken();

        // Step 2: Prepare meeting data
        $meetingData = [
            'topic' => $request->topic,
            'type' => 2, // Scheduled meeting
            'start_time' => $request->start_time,
            'duration' => $request->duration,
            'timezone' => 'Asia/Jerusalem',
            'password' => $request->password ?? '123456',
           'settings' => [
                'join_before_host'   => false,  // Participants CANNOT join before the host starts the meeting
                'host_video'         => true,   // Host video will be ON when the meeting starts
                'participant_video'  => true,   // Participant video will be ON when they join
                'waiting_room'       => true,   // Participants go to the waiting room until the host admits them
            ],

        ];

        // Step 3: Call Zoom API
        $response = Http::withToken($accessToken)
            ->post('https://api.zoom.us/v2/users/me/meetings', $meetingData);

        if ($response->failed()) {
            throw new \Exception('Zoom API Error: ' . $response->body());
        }

        // Step 4: Return the meeting details
        return (object) $response->json();
    }


    public function getZoomAccessToken()
    {
        $clientId = env('ZOOM_CLIENT_ID');
        $clientSecret = env('ZOOM_CLIENT_SECRET');
        $accountId = env('ZOOM_ACCOUNT_ID');

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