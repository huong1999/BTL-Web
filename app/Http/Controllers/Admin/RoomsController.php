<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subject;
use PDF;
use App\Room;
use App\Shift;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    protected $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $shift = $request->input('shift');

        $users = $this->room->getUser();
        $subjects = Subject::pluck('name', 'id');
        $shifts = Shift::pluck('name', 'id');

        $rooms = Room::with('shifts')
            ->when($shift, function ($query) use ($shift) {
                $query->where('id', $shift);
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");
            })
            ->latest()->paginate(25);

        return view('admin.rooms.index', compact('rooms', 'shifts', 'users', 'subjects'));
    }

    public function pdf()
    {
        $rooms = Room::get();
        $pdf = PDF::loadView('admin.roomList', compact('rooms'));

        return $pdf->download('room_exam.pdf');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $shifts = $this->room->getShift();
        $users = $this->room->getUser();

        return view('admin.rooms.create', compact('shifts', 'users'));
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
			'quantify' => 'required',
		]);
        $requestData = $request->all();

        Room::create($requestData);

        return redirect('admin/rooms')->with('flash_message', 'Room added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $room = Room::findOrFail($id);

        return view('admin.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $shifts = $this->room->getShift();
        $users = $this->room->getUser();

        $room_shifts = [];
        foreach ($room->shifts as $shift) {
            $room_shifts[] = $shift->name;
        }
        return view('admin.rooms.edit', compact('room', 'shifts', 'users', 'room_shifts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'name' => 'required',
			'quantify' => 'required',
		]);
        $requestData = $request->all();

        $room = Room::findOrFail($id);
        $room->update($requestData);

        return redirect('admin/rooms')->with('flash_message', 'Room updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Room::destroy($id);

        return redirect('admin/rooms')->with('flash_message', 'Room deleted!');
    }
}
