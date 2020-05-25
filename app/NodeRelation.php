<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NodeRelation extends Model
{
    public function parent(){
        return $this->belongsTo(Node::class,'to_id','id');
    }
}
