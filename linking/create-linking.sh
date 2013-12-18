#!/bin/sh
java -DconfigFile=external/linking.xml -jar silk.jar
java -DconfigFile=internal/linking.xml -jar silk.jar