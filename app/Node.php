<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'graph_id', 'tooltip',
    ];

    // Relation graph
    
    public function graph()
    {
        return $this->belongsTo(Graph::class);
    }
}
