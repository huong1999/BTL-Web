<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Shift extends Model
{
    use LogsActivity;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shifts';

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
    protected $fillable = ['name', 'exam_id', 'date_exam', 'start', 'end', 'subject_id'];



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

    public function exam()
    {
        return $this->belongsTo(Exam::class)->withDefault(['name' => 'Không tìm thấy kỳ thi !']);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class)->withDefault(['name' => 'Không tìm thấy môn học !']);
    }
}
