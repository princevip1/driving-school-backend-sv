<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Course::select('id', 'title', 'duration', 'price')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('theme.course.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('theme.course.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('theme.course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'duration' => 'required',
            'price' => 'required',
        ]);
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/course/'), $filename);
        }
        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->thumbnail = $filename ?? '';
        $course->duration = $request->duration;
        $course->price = $request->price;
        $course->save();
        return redirect()->route('course.list')->with('success', 'Course created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::where('id', $id)->first();
        return view('theme.course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $course = Course::find($id);
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'duration' => 'required',
            'price' => 'required',
        ]);
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/course/'), $filename);
            // delete image
            if (file_exists(public_path('uploads/course/' . $course->thumbnail))) {
                unlink(public_path('uploads/course/' . $course->thumbnail));
            }
        }
        $course->title = $request->title;
        $course->description = $request->description;
        $course->thumbnail = $filename ?? $course->thumbnail;
        $course->duration = $request->duration;
        $course->price = $request->price;
        $course->save();
        return redirect()->route('course.list')->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        // delete image
        if ($course->thumbnail != '') {
            if (file_exists(public_path('uploads/course/' . $course->thumbnail))) {
                unlink(public_path('uploads/course/' . $course->thumbnail));
            }
        }
        $course->delete();
        return redirect()->route('course.list')->with('success', 'Course deleted successfully');
    }
}
