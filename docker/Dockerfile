FROM fluxms/flux-eco-biotope:v2022-01-06-1 AS medi-eco-ilias-user-orchestrator-orbital

# |-------------------------------------------------------------------------- \
# | author martin@fluxlabs.ch
# |-------------------------------------------------------------------------- \

# |-------------------------------------------------------------------------- \
# | General Environment Variables
# |-------------------------------------------------------------------------- \
ENV FLUX_ECO_HTTP_SERVER_SIDECAR_HTTP_API_FQCN=MediEco\\IliasUserOrchestratorOrbital\\Adapters\\Api\\HttpApi
ENV MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_EXCEL_IMPORT_PATH=/app/data
ENV MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_API_CONFIG_PATH=https://raw.githubusercontent.com/learn-medi-ch/configs/main/medi-eco-ilias-user-orchestrator-orbital/prod

COPY --chown=www-data:www-data ./app /app
USER www-data
WORKDIR /app

ENTRYPOINT ["sh", "./docker_entrypoint.sh"]