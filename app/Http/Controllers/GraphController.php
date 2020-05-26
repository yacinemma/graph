<?php

namespace App\Http\Controllers;

use App\Graph;
use App\Node;
use App\NodeRelation;
use Illuminate\Http\Request;
use App\Http\Resources\Graph as GraphResource;
use App\Http\Resources\Node as NodeResource;
use App\Http\Resources\Link as LinkResource;

class GraphController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get graph
        $graph = Graph::findOrFail($id);

        if ($graph->delete()) {
            return new GraphResource($graph);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get graphs
        $graphs = Graph::orderBy('created_at', 'desc')->paginate(5);

        // Return collection of graphs as a resource

        return GraphResource::collection($graphs);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get nodes
        $nodes =  Node::where('graph_id', $id)->get();

        $links = NodeRelation::whereIn('from_id',$nodes->pluck('id')->toArray())->orWhereIn('to_id',$nodes->pluck('id')->toArray())->get(['from_id AS sid','to_id AS tid'])->toArray();

        // Return single graph as a resource

        return NodeResource::collection($nodes)->additional(compact('links'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $graph = new Graph;
        $graph->name = $request->input('name');
        $graph->description = $request->input('description');

        if ($graph->save()) {
            return new GraphResource($graph);
        }

    }

    public function edit($id,Request $request)
    {
        $graph = Graph::findOrFail($id);
        $graph->name = $request->input('name');
        $graph->description = $request->input('description');

        if ($graph->save()) {
            return new GraphResource($graph);
        }

    }

    public function statistics($id)
    {
        $graph = Graph::findOrFail($id);

        if ($graph) {
            $nodes =  Node::where('graph_id', $id)->get();

            $links = NodeRelation::whereIn('from_id',$nodes->pluck('id')->toArray())->orWhereIn('to_id',$nodes->pluck('id')->toArray())->get(['from_id AS sid','to_id AS tid'])->toArray();

            // Return single graph as a resource

            return NodeResource::collection($nodes)->additional(compact('links','graph'));
            
        }

        return response()->json([
            'msg' => 'Graph Not Found',
        ]);
    }

}