require('./bootstrap');

import Neovis from 'neovis.js';

var viz;

function draw() {
    var config = {
        container_id: "viz",
        server_url: `bolt://${process.env.MIX_NEO4J_HOST}:${process.env.MIX_NEO4J_PORT}`,
        server_user: process.env.MIX_NEO4J_USERNAME,
        server_password: process.env.MIX_NEO4J_PASSWORD,
        labels: {
            "Person": {
                caption: "name",
            },
        },
        relationships: {
            "MARRIED_TO": {
                thickness: "weight",
                caption: true,
            },
        },
        initial_cypher: "MATCH p=()-[r:MARRIED_TO]->() MATCH (n) RETURN p, n"
    };

    viz = new Neovis(config);
    viz.render();
}

if (document.getElementById('viz')) {
    window.onload = draw;
}
