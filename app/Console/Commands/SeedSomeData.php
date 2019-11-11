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
        $cypher = "CREATE (ZuzanaK:Person {name:'Zuzana K.'})
    CREATE (ZsMom:Person {name:'Z Mom'})
    CREATE (ZsMom)-[:PARENT_OF]->(ZuzanaK)";
        $client->run($cypher);

        $result = $client->run('MATCH (p:Person {}) RETURN p');
        foreach ($result->getRecords() as $record) {
            echo sprintf('Person name is : %s', $record->get('p')->value('name')) . "\n";
        }
    }
}
