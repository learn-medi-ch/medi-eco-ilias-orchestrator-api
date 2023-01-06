#!/bin/bash
sh ../app/bin/install-libraries.sh
docker build  ../ -f Dockerfile --target medi-eco-ilias-user-orchestrator-orbital -t fluxms/medi-eco-ilias-user-orchestrator-orbital:v2022-01-06-1