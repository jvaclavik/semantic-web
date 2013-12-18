#! /bin/bash

./triplifier/tarql/bin/tarql triplifier/continents.sparql > output/continents.rdf
./triplifier/tarql/bin/tarql triplifier/countries.sparql > output/countries.rdf
./triplifier/tarql/bin/tarql triplifier/unesco.sparql > output/unesco.rdf