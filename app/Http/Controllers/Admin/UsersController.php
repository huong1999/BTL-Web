<?php

namespace App\Http\Controllers\Admin;

use App\Classes;
use App\Http\Controllers\Controller;
use App\User;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
        /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $roles = $this->user->getRole();
        $rooms = $this->user->getRoom();
        $classes = $this->user->getClass();
        $subjects = $this->user->getSubject();
        $users = $this->user->getType($request);

        return view('admin.users.index', compact('users', 'roles', 'classes', 'rooms', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $roles = $this->user->getRole();
        $rooms = $this->user->getRoom();
        $classes = $this->user->getClass();
        $subjects = $this->user->getSubject();

        return view('admin.users.create', compact('roles', 'classes', 'rooms', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return void
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|string|max:255|email|unique:users',
                'password' => 'required',
                'roles' => 'required',
            ]
        );

        $user = $this->user->addUser($request);

        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect('admin/users')->with('flash_message', 'User added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        $roles = $this->user->getRole();
        $rooms = $this->user->getRoom();
        $classes = $this->user->getClass();
        $subjects = $this->user->getSubject();
        $user = User::with('roles', 'rooms', 'subjects')->findOrFail($id);
        $user_roles = [];
        foreach ($user->roles as $role) {
            $user_roles[] = $role->name;
        }
        $user_rooms = [];
        foreach ($user->rooms as $room) {
            $user_rooms[] = $room->name;
        }
        $user_subjects = [];
        foreach ($user->subjects as $subject) {
            $user_subjects[] = $subject->name;
        }

        return view('admin.users.edit', compact('user', 'roles', 'rooms', 'subjects', 'user_roles', 'user_rooms', 'user_subjects', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int      $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|string|max:255|email|unique:users,email,' . $id,
                'roles' => 'required'
            ]
        );

        $data = $request->except('password');
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user = User::findOrFail($id);
        $user->update($data);

        $user->roles()->detach();

        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect('admin/users')->with('flash_message', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect('admin/users')->with('flash_message', 'User deleted!');
    }
}
