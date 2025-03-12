<?php

namespace App\Http\Controllers\backend\Api\Students\OnlineClasses;

use Illuminate\Http\Request;
use App\Models\online_classe;
use App\Http\Controllers\Controller;
use App\Http\Traits\MeetingZoomTrait;
use App\Http\Requests\Students\OnlineClasses\StoreOnlineClass;
use App\Http\Requests\Students\OnlineClasses\UpdateOnlineClass;

class ApiOnlineClasseController extends Controller
{
    use MeetingZoomTrait;

    /**
     * عرض جميع الحصص الأونلاين.
     */
    public function index()
    {
        $online_classes = online_classe::where('created_by', auth()->user()->email)->get();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Online Classes',
            'data' => $online_classes,
        ]);
    }

    /**
     * إنشاء حصة أونلاين جديدة باستخدام Zoom.
     */
    public function store(StoreOnlineClass $request)
    {
        try {
            $meeting = $this->createMeeting($request);
            $onlineClass = online_classe::create([
                'integration' => true,
                'Grade_id' => $request->Grade_id,
                'Classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'created_by' => auth()->user()->email,
                'meeting_id' => $meeting->id,
                'topic' => $request->topic,
                'start_at' => $request->start_time,
                'duration' => $meeting->duration,
                'password' => $meeting->password,
                'start_url' => $meeting->start_url,
                'join_url' => $meeting->join_url,
            ]);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Online Class created successfully',
                'data' => $onlineClass,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating online class',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * تحديث بيانات الحصة الأونلاين.
     */
    public function update(UpdateOnlineClass $request, $id)
    {
        try {
            $onlineClass = online_classe::find($id);
            if (!$onlineClass) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Online class not found',
                ]);
            }

            $onlineClass->update($request->validated());

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Online Class updated successfully',
                'data' => $onlineClass,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating online class',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * حذف حصة أونلاين.
     */
    public function destroy($id)
    {
        try {
            $onlineClass = online_classe::find($id);
            if (!$onlineClass) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Online class not found',
                ]);
            }

            $onlineClass->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Online Class deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting online class',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
