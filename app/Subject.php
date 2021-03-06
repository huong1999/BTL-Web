<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Subject extends Model
{
    use LogsActivity;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subjects';

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
    protected $fillable = ['name'];



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

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function room()
    {
        return $this->belongsTo(Room::class)->withDefault(['name' => 'Không tìm thấy kỳ thi !']);
    }

    public function getRoom()
    {
        $rooms = Room::pluck('name', 'id');

        return $rooms;
    }

}
