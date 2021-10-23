<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Previous_searches;
use App\Models\Previous_search_results;
use Illuminate\Support\Facades\DB;

class WordDefinitionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = [];
        $wordDefinitions = [];

        $words = DB::table('previous_searches')->orderBy('created_at', 'DESC')->get();

        foreach ($words as $word) {
            $definitions = DB::table('previous_search_results')->where('result_id',$word->id)->orderBy('created_at', 'DESC')->get();
            
            $word->definitions = [];
            foreach ($definitions as $definition) {
                array_push($word->definitions, $definition);
            }
            array_push($wordDefinitions, $word);
        }
        return $wordDefinitions ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newSearch = new Previous_searches;
        $newSearch->word = $request->word;
        $newSearch->save();

        $wordId = $newSearch->id;

        foreach($request->definitions as $definition) {
            $newWordDefinitions = new Previous_search_results;
            $newWordDefinitions->result_id = $wordId;
            $newWordDefinitions->definition = $definition['definition'];
            $newWordDefinitions->author = $definition['author'];        
            $newWordDefinitions->save();
        }

        return (object)array("result" => "success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $word = DB::table('previous_searches')->orderBy('created_at', 'DESC')->find($id);

        $definitions = DB::table('previous_search_results')->where('result_id',$word->id)->orderBy('created_at', 'DESC')->get();
        $word->definitions = [];
        foreach ($definitions as $definition) {
            array_push($word->definitions, $definition);
        }

        return $word ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
