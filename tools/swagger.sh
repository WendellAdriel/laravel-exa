#!/bin/bash

php ./vendor/bin/openapi --bootstrap ./tools/swagger-constants.php --output ./public/swagger/swagger ./app ./modules
