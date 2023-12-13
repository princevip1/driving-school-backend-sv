<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\History;
use App\Models\Teacher;
use App\Models\UserCourse;
use Illuminate\Http\Request;

class TruckingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function update_trucking_activity(Request $request)
    {
        $course = UserCourse::where('user', auth()->user()->id)->where('status', "progress")->first();

        $history = History::where('user', auth()->user()->id)->where('course', $course->course)->where('date', date("Y-m-d"))->first();

        if (!$history) {
            $history = new History();
            $history->date = date("Y-m-d");
            $history->duration = 0;
        }

        if ($request->seconds) {
            $history->duration = $history->duration +  ($request->seconds * 1000);
        } else {
            $history->duration = $history->duration + 1000  * 60;
        }

        $history->teacher = $request->teacher;
        $history->course = $course->course;
        $history->user = auth()->user()->id;
        $history->save();
        return response()->json([
            'message' => 'success',
            'data' => $history
        ]);
    }


    public function previous_trucking_activity()
    {
        $coursees = UserCourse::where('user', auth()->user()->id)->get();
        $all_history = History::where('user', auth()->user()->id)->get();
        $total_course_duration_hours = 0;
        foreach ($coursees as $key => $value) {
            $total_course_duration_hours = $total_course_duration_hours + $value->duration;
        }
        $total_history_duration = 0;
        foreach ($all_history as $key => $value) {
            $total_history_duration = $total_history_duration + $value->duration;
        }
        $total_history_duration_in_hours = floor($total_history_duration / 3600000);
        if ($total_history_duration_in_hours && $total_course_duration_hours  >= $total_history_duration_in_hours) {
            return response()->json([
                'message' => 'success',
                'data' =>   [
                    'hours' => $total_course_duration_hours,
                    'minutes' => 0,
                    'seconds' => 0,
                ]
            ]);
        }
        $history = History::where('user', auth()->user()->id)->get();
        $total_duration = 0;
        foreach ($history as $key => $value) {
            $total_duration = $total_duration + $value->duration;
        }
        $hours = floor($total_duration / 3600000);
        $minutes = floor(($total_duration / 60000) % 60);
        $seconds = floor(($total_duration / 1000) % 60);
        return response()->json([
            'message' => 'success',
            'data' =>   [
                'hours' => $hours,
                'minutes' => $minutes,
                'seconds' => $seconds,
            ]
        ]);
    }


    public function trucking_activity_history()
    {
        $history = History::where('user', auth()->user()->id)->get();
        foreach ($history as $key => $value) {
            $value->hours = floor($value->duration / 3600000);
            $value->minutes = floor(($value->duration / 60000) % 60);
            $value->seconds = floor(($value->duration / 1000) % 60);
            $value->teacher_name = Teacher::where('id',  $value->teacher)->first()->name;
            $value->course_name = Course::where('id',  $value->course)->first()->name;
            $value->teacher_profile_picture =
                url('uploads/teacher/' . Teacher::where('id',  $value->teacher)->first()->profile_picture);
        }
        return response()->json([
            'message' => 'success',
            'data' => $history
        ]);
    }
}
