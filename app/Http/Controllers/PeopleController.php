<?php

namespace App\Http\Controllers;

use App\Person;
use GraphAware\Bolt\Protocol\V1\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        return view('people.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        $results = app(Session::class)
            ->run("MATCH (p:Person)-[]-(friends) WHERE p.eloquentId = \"{$person->id}\" RETURN p, friends")
            ->getRecords();

        $first = Arr::first($results);
        $personKey = array_search('p', $first->keys());
        $friendKey = array_search('friends', $first->keys());

        $person = $first->values()[$personKey];

        $friends = collect($results)->map(function ($result) use ($friendKey) {
            return $result->values()[$friendKey];
        })->toArray();

        return view('people.show', [
            'person' => $person,
            'relationships' => $friends,
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
