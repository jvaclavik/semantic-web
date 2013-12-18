#! /bin/bash

curl http://whc.unesco.org/en/list/xls/ > cache/unesco.xls
#libreoffice --headless --convert-to csv cache/unesco.xls --outdir cache/

curl http://unstat.orgfree.com/global/country/csv/data.csv > cache/countries.csv

java -jar ./java_app/SWEGetData.jar

