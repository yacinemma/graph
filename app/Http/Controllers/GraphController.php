<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Graph;
use App\Http\Resources\Graph as GraphResource;

class GraphController extends Controller
{
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

        if($graph->save()) {
            return new GraphResource($graph);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get graph
        $graph = Graph::findOrFail($id);

        // Return single graph as a resource
        return new GraphResource($graph);
    }

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

        if($graph->delete()) {
            return new GraphResource($graph);
        }    
    }
}