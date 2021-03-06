<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseType;
use App\Http\Requests\CourseRequest;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coursesByType = CourseType::with('courses')->get();
        $user = auth()->user();
        return view('back.courses.index', compact('coursesByType', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courseTypes = CourseType::with('participants')->orderBy('name', 'asc')->pluck('name', 'id');;
        return view('back.courses.create', compact('courseTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $course = new Course($request->validated());
        $course->team_id = auth()->user()->currentTeam->id;

        $course->save();
        return redirect()->route('courses.show', compact('course'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return view('back.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('back.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CourseRequest  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        dd('test');
        $course = $course->fill($request->validated());
        $course->save();
        return redirect()->route('courses.show', compact('course'));
    }

    public function signup(Course $course)
    {
        dd($course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        return false;
    }
}
