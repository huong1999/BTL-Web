<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Room extends Model
{
    use LogsActivity;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'quantify'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function shifts()
    {
        return $this->belongsToMany('App\Shift', 'room_shift');
    }

    /**
     * Change activity log event description
     *
     * @param string $eventName
     *
     * @return string
     */
    public function getDescriptionForEvent($eventName)
    {
        return __CLASS__ . " model has been {$eventName}";
    }

    public function subjects()
    {
        return $this->hasMany('App\Subject');
    }

    public function getShift() {
        $shifts = Shift::pluck('name');

        return $shifts;
    }

    public function isShift($keyword)
    {
        return $this->shifts()->where('name', 'LIKE', "%$keyword%");
    }

    public function getUser() {
        $users = User::pluck('name', 'code', 'date_of_birth', 'email');

        return $users;
    }

}
