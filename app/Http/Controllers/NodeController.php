<?php

namespace App\Http\Controllers;

use App\Node;
use App\NodeRelation;
use Illuminate\Http\Request;

class NodeController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete node
        $node = Node::findOrFail($id);
        if ($node->delete()) {
        	NodeRelation::where('from_id',$id)->orWhere('to_id',$id)->delete();
            return response()->json([
			    'msg' => 'Node Deleted',
			]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $node = new Node;
        $node->graph_id = $request->graph_id;
        $node->tooltip  = $request->tooltip;
        if ($node->save()) {
        	$node->childrens()->attach($request->parents);
            return $node;
        }
        return ;

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $node = Node::findOrFail($id);
        $node->graph_id = $request->input('graph_id');
        $node->tooltip  = $request->input('tooltip');

        if ($node->save()) {
        	$node->childrens()->sync($request->parents);
            return $node;
        }

    }

}