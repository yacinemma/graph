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
        'graph_id', 'tooltip', 'parent_id',
    ];

    protected $casts = [
        'parent_id' => 'array',
    ];

    // Relation graph
    
    public function graph()
    {
        return $this->belongsTo(Graph::class);
    }

    public function childrens(){
        return $this->belongsToMany('App\Node', 'node_relations', 
      'to_id', 'from_id');
    }

    public function parents(){
        return $this->belongsToMany('App\Node', 'node_relations', 
      'from_id', 'to_id')->select('to_id');
    }

    
}
