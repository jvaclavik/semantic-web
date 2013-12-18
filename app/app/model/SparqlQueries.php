<?php

namespace swe\model;

use Nette\Object;
use stekycz\NetteSesame\SesameClient;


class SparqlQueries extends Object
{

    /**
     * @var \stekycz\NetteSesame\SesameClient
     */
    private $sesameClient;


    public function __construct(SesameClient $sesameClient)
    {
        $this->sesameClient = $sesameClient;
    }


    public function getUnescoList()
    {
        return $this->sesameClient->query("

PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX dbp: <http://dbpedia.org/ontology/>
PREFIX dbp-prop: <http://dbpedia.org/property/>

SELECT
  distinct *

WHERE {
  ?country a dbp:Country;
    rdfs:label ?countryName;
    dbp:Continent ?continentName.

  ?continent a dbp:Continent;
    rdfs:label ?continentName.

  ?unesco a dbp:WorldHeritageSite;
    rdfs:label ?unescoName;
    dbp:Country ?countryName.
}

		");
    }

    public function getCountry($c)
    {
        return $this->sesameClient->query("

PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX dbp: <http://dbpedia.org/ontology/>
PREFIX dbp-prop: <http://dbpedia.org/property/>
PREFIX dbp-pp:  <http://dbpedia.org/ontology/PopulatedPlace/>

SELECT
  distinct *

WHERE {
  ?country a dbp:Country;
    rdfs:label '$c'@en;
    rdfs:label ?countryName;
    dbp:Continent ?continentName;
    dbp-prop:gdpNominalPerCapita ?gdp;
    dbp-prop:populationEstimateYear ?population;
    dbp-pp:areaTotal ?area.
}

		");


    }

    public function getCountryInContinent($c)
    {
        return $this->sesameClient->query("

PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX dbp: <http://dbpedia.org/ontology/>
PREFIX dbp-prop: <http://dbpedia.org/property/>
PREFIX dbp-pp:  <http://dbpedia.org/ontology/PopulatedPlace/>

SELECT
  distinct *

WHERE {
  ?country a dbp:Country;
    dbp:Continent '$c'@en;
    rdfs:label ?countryName;
}
		");
    }

    public function getContinent($c)
    {
        return $this->sesameClient->query("

PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX dbp: <http://dbpedia.org/ontology/>
PREFIX dbp-prop: <http://dbpedia.org/property/>
PREFIX dbp-pp:  <http://dbpedia.org/ontology/PopulatedPlace/>

SELECT
  distinct *

WHERE {
  ?continent a dbp:Continent;
    rdfs:label '$c'@en;
    rdfs:label ?continentName;
    dbp-pp:areaTotal ?area;
    dbp-pp:density ?density;
    dbp-prop:population ?population;
}
		");
    }

    public function getUnesco($c)
    {
        return $this->sesameClient->query("

PREFIX schema: <http://schema.org/>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX dbp: <http://dbpedia.org/ontology/>
PREFIX dbp-prop: <http://dbpedia.org/property/>
PREFIX dbp-pp:  <http://dbpedia.org/ontology/PopulatedPlace/>

SELECT
  distinct *

WHERE {
  ?unesco a dbp:WorldHeritageSite;
    rdfs:label '$c'@en;
    rdfs:label ?unescoName;
    dbp:type?category;
    dbp:year ?yearInscribed;
    schema:latitude ?latitude;
    schema:longitude ?longitude;
    schema:description ?description;
    dbp:Country ?countryName.
}
		");
    }


    public function getUnescoFromContinent($c)
    {
        return $this->sesameClient->query("


PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX dbp: <http://dbpedia.org/ontology/>
PREFIX dbp-prop: <http://dbpedia.org/property/>
PREFIX dbp-pp:  <http://dbpedia.org/ontology/PopulatedPlace/>

SELECT
  distinct *
WHERE {
  ?country a dbp:Country;
    rdfs:label ?countryName;
    dbp:Continent '$c'@en.

  ?unesco a dbp:WorldHeritageSite;
    rdfs:label ?unescoName;
    dbp:Country ?countryName.
}

		");
    }

    public function getUnescoFromCountry($c)
    {
        return $this->sesameClient->query("

PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX dbp: <http://dbpedia.org/ontology/>
PREFIX dbp-prop: <http://dbpedia.org/property/>
PREFIX dbp-pp:  <http://dbpedia.org/ontology/PopulatedPlace/>

SELECT
  distinct *
WHERE {
  ?unesco a dbp:WorldHeritageSite;
    rdfs:label ?unescoName;
    dbp:Country '$c'@en.
}

		");
    }
    public function getContinentsWithMostOfSights()
    {
        return $this->sesameClient->query("


PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX dbp: <http://dbpedia.org/ontology/>
PREFIX dbp-prop: <http://dbpedia.org/property/>
PREFIX dbp-pp:  <http://dbpedia.org/ontology/PopulatedPlace/>

SELECT
  ?area
  ?continentName
  (COUNT(?continentName) as ?count)

WHERE {
  ?unesco a dbp:WorldHeritageSite;
    rdfs:label ?unescoName;
    dbp:Country ?countryName.

  ?country a dbp:Country;
    rdfs:label ?countryName;
    dbp:Continent ?continentName.

  ?continent a dbp:Continent;
    rdfs:label ?continentName;
    dbp-pp:areaTotal ?area.

} GROUP BY
  ?area ?continentName

ORDER BY
  DESC(?count)

		");
    }



    public function getCountryWithMostOfSights()
    {
        return $this->sesameClient->query("


PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX dbp: <http://dbpedia.org/ontology/>
PREFIX dbp-prop: <http://dbpedia.org/property/>
PREFIX dbp-pp:  <http://dbpedia.org/ontology/PopulatedPlace/>

SELECT
  ?area
  ?countryName
  (COUNT(?countryName) as ?count)

WHERE {
  ?country a dbp:Country;
    rdfs:label ?countryName;
    dbp-pp:areaTotal ?area.

  ?unesco a dbp:WorldHeritageSite;
    rdfs:label ?unescoName;
    dbp:Country ?countryName.
}

GROUP BY
  ?area
  ?countryName

ORDER BY
  DESC(?count)

		");
    }


}
