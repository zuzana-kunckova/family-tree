<?php

namespace App\Console\Commands;

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Session $client)
    {
        $cypher = "CREATE (Adam:Person {name:'Adam'})
    CREATE (Eve:Person {name:'Eve'})
    CREATE (Eve)-[:MARRIED_TO]->(Adam)
    CREATE (Cain:Person {name:'Cain'})
    CREATE (Abel:Person {name:'Abel'})
    CREATE (Cain)-[:CHILD_OF]->(Adam)
    CREATE (Cain)-[:CHILD_OF]->(Eve)
    CREATE (Abel)-[:CHILD_OF]->(Adam)
    CREATE (Abel)-[:CHILD_OF]->(Eve)";
        $client->run($cypher);

        $result = $client->run('MATCH (p:Person {}) RETURN p');
        foreach ($result->getRecords() as $record) {
            echo sprintf('Person name is : %s', $record->get('p')->value('name')) . "\n";
        }
    }
}
