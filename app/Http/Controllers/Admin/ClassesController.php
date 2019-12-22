<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $classes = Classes::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $classes = Classes::latest()->paginate($perPage);
        }

        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();

        Classes::create($requestData);

        return redirect('admin/classes')->with('flash_message', 'Class added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return View
     */
    public function show($id)
    {
        $class = Classes::findOrFail($id);

        return view('admin.classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return View
     */
    public function edit($id)
    {
        $class = Classes::findOrFail($id);

        return view('admin.classes.edit', compact('class'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();

        $class = Classes::findOrFail($id);
        $class->update($requestData);

        return redirect('admin/classes')->with('flash_message', 'Class updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        Classes::destroy($id);

        return redirect('admin/classes')->with('flash_message', 'Class deleted!');
    }
}
