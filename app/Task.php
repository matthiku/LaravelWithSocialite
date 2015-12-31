<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Task extends Model
{

    /**
     * We use the soft delete feature of Laravel to mark tasks as being done
     * With that, we keep the tasks in the DB and can recover them if needed.
     */
	use SoftDeletes;


    // this is the default table name, so this statement is optional
    protected $table = 'tasks';

    // Mass asignable
    protected $fillable = ['name', 'date', 'category_id', 'user_id'];

    // hidden fields
    protected $hidden = [];
    


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date', 'deleted_at'];




    /**
     * A task belongs to a user
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * A task belongs to one category
     */
    public function category() {
        return $this->belongsTo('App\Category');
    }

}
