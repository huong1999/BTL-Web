<?php

namespace App\Http\Controllers\Admin;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Shift;
use App\Subject;
use Illuminate\Http\Request;

class ShiftsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $exam = $request->input('exam');
        $subject = $request->input('subject');
        $perPage = 25;
        $exams = Exam::pluck('name', 'id');
        $subjects = Subject::pluck('name', 'id');
        $shifts = Shift::with('exam')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");
            })
            ->when($exam, function ($query) use ($exam) {
                $query->where('exam_id', $exam);
            })
            ->when($subject, function ($query) use ($subject) {
                $query->where('subject_id', $subject);
            })
            ->latest()->paginate($perPage);

        return view('admin.shifts.index', compact('shifts', 'exams', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $exams = Exam::pluck('name', 'id');
        $subjects = Subject::pluck('name', 'id');
        return view('admin.shifts.create', compact('exams', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'exam_id' => 'required',
            'date_exam' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);
        $requestData = $request->all();

        Shift::create($requestData);

        return redirect('admin/shifts')->with('flash_message', 'Shift added!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $shift = Shift::findOrFail($id);

        return view('admin.shifts.show', compact('shift'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        $exams = Exam::pluck('name', 'id');
        $subjects = Subject::pluck('name', 'id');
        return view('admin.shifts.edit', compact('shift', 'exams', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'exam_id' => 'required',
            'date_exam' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);
        $requestData = $request->all();

        $shift = Shift::findOrFail($id);
        $shift->update($requestData);

        return redirect('admin/shifts')->with('flash_message', 'Shift updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Shift::destroy($id);

        return redirect('admin/shifts')->with('flash_message', 'Shift deleted!');
    }
}
