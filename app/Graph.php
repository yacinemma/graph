<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];

    // relation Node 
    
    public function nodes()
    {
        return $this->hasMany(Node::class);
    }

}
