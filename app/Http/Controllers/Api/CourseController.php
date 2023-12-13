<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\History;
use App\Models\UserCourse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getAllCourse()
    {
        $courses = Course::select('id', 'title', 'description', 'price', 'duration', 'thumbnail')->orderBy('created_at', 'asc')->get();
        // set profile picture url
        foreach ($courses as $course) {
            $course->thumbnail = url('uploads/course/' . $course->thumbnail);
        }
        return response()->json([
            'data' => $courses,
            "message" => "success",
            "status" => 200,
        ]);
    }

    public function getOneById($id)
    {
        $course = Course::find($id);
        // set profile picture url
        $course->thumbnail = url('uploads/course/' . $course->thumbnail);
        return response()->json([
            'data' => $course,
            "message" => "success",
            "status" => 200,
        ]);
    }

    public function getAllCourseDuration()
    {
        $user_courses = UserCourse::where('user', auth()->user()->id)->get();
        $courses_hours = 0;
        foreach ($user_courses as $key => $value) {
            $course = Course::find($value->course);
            $courses_hours = $courses_hours + $course->duration;
        }
        $total_duration = 0;
        $total_driving_hours = 0;
        $total_driving_minutes = 0;
        $total_driving_seconds = 0;
        $driving_histories = History::where('user', auth()->user()->id)->get();
        foreach ($driving_histories as $key => $value) {
            $total_duration = $total_duration + $value->duration;
        }
        $total_driving_hours = floor($total_duration / 3600000);
        $total_driving_minutes = floor(($total_duration / 60000) % 60);
        $total_driving_seconds = floor(($total_duration / 1000) % 60);
        return response()->json([
            'data' =>  [
                'total_hour' => $courses_hours,
                'hours' =>  $total_driving_hours,
                'minutes' =>  $total_driving_minutes,
                'seconds' =>  $total_driving_seconds,
            ],
            "message" => "success",
            "status" => 200,
        ]);
    }


    public function getYourCourse()
    {
        $user_courses = UserCourse::where('user', auth()->user()->id)->get();
        $courses = [];
        foreach ($user_courses as $key => $value) {
            $course = Course::find($value->course);
            $course->thumbnail = url('uploads/course/' . $course->thumbnail);
            $courses[] = $course;
        }
        return response()->json([
            'data' => $courses,
            "message" => "success",
            "status" => 200,
        ]);
    }
}
