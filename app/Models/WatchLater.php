<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WatchLater extends Model
{

    protected $guarded = [];
    protected $table = 'WatchLater';

    /**
     * Get the index name for the model.
     *
     * @return array
     */

    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }



}