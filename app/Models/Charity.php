<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB as DB;
use BiscuitLabs\Lighthouse;

class Charity extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'charity';
    public $timestamps = true;

    protected $guarded = [];

//
//    /**
//     * The attributes that are mass assignable.
//     *
//     * @var array
//     */
    protected $fillable = ['location'];
//
//    /**
//     * The attributes excluded from the model's JSON form.
//     *
//     * @var array
//     */
//    protected $hidden = ['password', 'remember_token'];

    /**
     * Location setter (for custom data type)
     *
     * @param array $value
     */
    public function setLocationAttribute(array $value)
    {
        $this->attributes['location'] = DB::raw("ST_GeomFromText('POINT(".$value[0]." ".$value[1].")', 4326)");
    }

    public function getLocationAttribute() {
        $point = new Lighthouse\Geometry\Base();
        return $point;
//        $point = $parser->parse($this->attributes['location']);
//        $raw_location = $parser->parse($this->attributes['location']);
//        return $raw_location->out('json');
    }
}
