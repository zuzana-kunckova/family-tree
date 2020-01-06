<?php

namespace App\Http\Controllers;

use App\Person;
use GraphAware\Bolt\Protocol\V1\Session as Neo4j;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('people.index', [
            'people' => Person::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('people.create',[
            'people' => Person::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Neo4j $client)
    {
        $this->validate($request, [
            'name' => 'required',
            'relationship' => 'required',
            'related_to' => 'required',
        ]);

        $person = Person::create(['name' => $request->name]);

        $relationship = [
            'Parent' => '@todo',
            'Sibling' => '@todo',
            'Child' => 'CHILD_OF',
            'Spouse' => 'MARRIED_TO',
        ][$request->relationship];

        $cypher = sprintf(
            "CREATE (new_person:Person {name:'%s',eloquentId:%s})\n MERGE (related_to:Person {eloquentId:%s})\n MERGE (new_person)-[:%s]->(related_to)",
            $person->name,
            $person->id,
            $request->related_to,
            $relationship
        );

        $client->run($cypher);

        return redirect()->route('people.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        $results = app(Neo4j::class)
            ->run("MATCH (p:Person)-[]-(friend) WHERE p.eloquentId = {$person->id} RETURN p, collect(friend) as friends")
            ->firstRecord();

        $personKey = array_search('p', $results->keys());
        $friendKey = array_search('friends', $results->keys());

        $siblings = app(Neo4j::class)
            ->run("MATCH (p:Person)-[:CHILD_OF]-(parent)-[:CHILD_OF]-(sibling) WHERE p.eloquentId = {$person->id}
            RETURN collect(sibling) as siblings")
            ->firstRecord();

        return view('people.show', [
            'person' => $results->values()[$personKey],
            'relationships' => $results->values()[$friendKey],
            'siblings' => $siblings->values()[0],
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }
}
