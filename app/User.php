<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'class_id', 'date_of_birth', 'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isUser()
    {
        return $this->roles()->where('name', 'user');
    }

    public function isAdmin()
    {
        return $this->roles()->where('name', 'admin');
    }

    public function rooms()
    {
        return $this->belongsToMany('App\Room');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Subject');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class)->withDefault(['name' => 'Không tìm thấy lớp học !']);
    }

    public function getType($request){
        $class = $request->get('class');
        $keyword = $request->get('search');
        $type = $request->input('role') == 'admin'? 'isAdmin' : 'isUser';
        $users = User::has($type)
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");
            })
            ->when($class, function ($query) use ($class) {
                $query->where('class_id', $class);
            })
            ->latest()->paginate(15);

        return $users;
    }

    public function addUser($request) {
        $data = $request->except('password');
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);

        return $user;
    }

    public function getRole()
    {
        $roles = Role::pluck('label', 'name');
        return $roles;
    }

    public function getClass()
    {
        $classes = Classes::pluck('name', 'id');
        return $classes;
    }

    public function getRoom()
    {
        $rooms = Room::pluck('name', 'id', 'shift_id', 'quantify');

        return $rooms;
    }

    public function getSubject()
    {
        $subjects = Subject::pluck('name');

        return $subjects;
    }

}
