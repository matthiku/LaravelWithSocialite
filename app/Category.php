<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    // Mass asignable
    protected $fillable = ['name'];

	/**
	 * A Category can have many tasks...
	 */
	public function tasks() {
		return $this->hasMany('App\Task');
	}

}
