#!/bin/bash
sh ../app/bin/install-libraries.sh
docker build  ../ -f Dockerfile --target medi-eco-ilias-user-orchestrator-api -t fluxms/medi-eco-ilias-user-orchestrator-api:v2022-12-30-1
docker build  ../ -f Dockerfile --target medi-eco-ilias-user-orchestrator-api -t fluxms/medi-eco-ilias-user-orchestrator-api:latest