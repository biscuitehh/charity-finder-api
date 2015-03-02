<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Charity extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'charity';
    public $timestamps = true;
//
//    /**
//     * The attributes that are mass assignable.
//     *
//     * @var array
//     */
//    protected $fillable = ['name', 'email', 'password'];
//
//    /**
//     * The attributes excluded from the model's JSON form.
//     *
//     * @var array
//     */
//    protected $hidden = ['password', 'remember_token'];

}
