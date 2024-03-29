<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user() {
    	return $this->belongsTo('App\User');
    }
    
    public static function edit($id)
    {
        return self::find($id);
    }
    public static function updateDosen($id, $data)
    {
        $dosen = self::find($id);
        $dosen->update($data);

        return $dosen;
    }
}
