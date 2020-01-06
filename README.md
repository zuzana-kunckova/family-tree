# Family tree

Family tree a web app that allows user to build their family tree. Users will be able to add more family members to the tree, add information about them, and even create a timeline depicting a person's journey through life. Users will also be able to invite other family members to view or edit their tree, to export the tree or to share a link to it.

This project is in active development.

## Technologies used

- [Laravel 6.*](https://laravel.com/)
- [Neo4j graph database](http://neo4j.com/) - a native graph database
- [Neovis.js](https://github.com/neo4j-contrib/neovis.js/) - Graph visualizations library powered by [vis.js](https://visjs.org/) with data from Neo4j
- [Graphaware PHP Client for Neo4j](https://github.com/graphaware/neo4j-php-client)

## Installation
1. Fork this repo
2. Clone it to your own computer
3. Install [Neo4j Desktop](https://neo4j.com/product/#desktop)
4. Create a new project in Neo4j Desktop and create a new local graph. Once the graph is running, click on the Neo4j Browser. Refer to the Neo4j documentation for more instructions about how to use Neo4j.
5. The current branch in development is `mes/neo4j` . Check it out in your terminal to have access to the latest code.
6. Create your `.env` file and make sure you add the correct username and password for your Neo4j and your mySQL databases
7. Run `php artisan seedSomeData` in your terminal to seed your graph database with the initial test data
8. You can now see this test data in the Neo4j Browser

## How does it work?
The graph database is currently seeded by running the `php artisan seedSomeData` command. 

The function `createPerson($name)` creates a new person, inserts it into Eloquent and Neo4j, and creates a link between these two databases through the `id`.

In the `handle()` method, we created an array of random people `$names`, and run `foreach` on this array so that every person in this array becomes a new person in the databases, and a `$cypher` variable, which is a string of `cypher` queries that creates various relationships between the people. 

When we run the `seedSomeData` command, the `handle()` method will run, all people in the `$names` array will be created together with their relationships. 

This way of seeding the database is just temporary while we are working on other aspects of the app.

## Contribute
This project is in active development and we are figuring it out as we go. If you would like to contrigute, please create an issue or submit a pull request. 

We welcome any help and suggestions!

## Roadplan
We will remove Neovis.js and replace it with Vis.js since Neovis.js exposes database credentials in the code and we haven't found a way to go around it yet.

## Watch us struggle
The development of Family Tree is currently being live-streamed on [Matt Stauffer's streaming channels]( https://mattstauffer.com/stream/). We are streaming (almost) every Monday at 2.45pm eastern time (7.45pm GMT).