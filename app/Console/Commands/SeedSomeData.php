<?php

namespace App\Console\Commands;

use App\Person;
use GraphAware\Bolt\Protocol\V1\Session;
use Illuminate\Console\Command;

class SeedSomeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seedsomedata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function createPerson($name)
    {
        // Insert into Eloquent and get ID
        $id = Person::create(['name' => $name])->id;

        // Insert into neo4j and link to eloquent
        $cypher = "CREATE (Adam:Person {name:'" . $name . "',eloquentId:'" . $id . "'})";
        $this->client->run($cypher);
    }

    public function wipe()
    {
        $this->client->run("MATCH (n) detach delete n");
        Person::truncate();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Session $client)
    {
        $this->client = $client;

        $this->wipe();

        $names = [
            'Adam',
            'Eve',
            'Cain',
            'Abel',
        ];

        foreach ($names as $name) {
            $this->createPerson($name);
        }

                // @todo handle relationships

                $cypher = "
            MERGE (adam:Person {name:'Adam'})
            MERGE (eve:Person {name:'Eve'})
            MERGE (cain:Person {name:'Cain'})
            MERGE (abel:Person {name:'Abel'})
            MERGE (eve)-[:MARRIED_TO]->(adam)
            MERGE (cain)-[:CHILD_OF]->(adam)
            MERGE (cain)-[:CHILD_OF]->(eve)
            MERGE (abel)-[:CHILD_OF]->(adam)
            MERGE (abel)-[:CHILD_OF]->(eve)";
                $client->run($cypher);

        // @todo handle relationships

    //     $cypher = "CREATE (Adam:Person {name:'Adam'})
    // CREATE (Eve:Person {name:'Eve'})
    // CREATE (Eve)-[:MARRIED_TO]->(Adam)
    // CREATE (Cain:Person {name:'Cain'})
    // CREATE (Abel:Person {name:'Abel'})
    // CREATE (Cain)-[:CHILD_OF]->(Adam)
    // CREATE (Cain)-[:CHILD_OF]->(Eve)
    // CREATE (Abel)-[:CHILD_OF]->(Adam)
    // CREATE (Abel)-[:CHILD_OF]->(Eve)";
    //     $client->run($cypher);

        // $result = $client->run('MATCH (p:Person {}) RETURN p');
        // foreach ($result->getRecords() as $record) {
        //     echo sprintf('Person name is : %s', $record->get('p')->value('name')) . "\n";
        // }
    }
}
