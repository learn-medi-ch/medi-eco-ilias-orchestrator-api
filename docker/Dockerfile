FROM fluxms/flux-eco-biotope:v2022-01-08-4 AS medi-eco-ilias-user-orchestrator-orbital

# |-------------------------------------------------------------------------- \
# | author martin.studer@medi.ch
# |-------------------------------------------------------------------------- \

# |-------------------------------------------------------------------------- \
# | General Environment Variables
# |-------------------------------------------------------------------------- \
ENV FLUX_ECO_HTTP_SYNAPSE_AUTOLOAD_FILE_PATH=/opt/medi-eco-ilias-user-orchestrator-orbital/app/autoload.php
ENV FLUX_ECO_HTTP_SYNAPSE_HTTP_API_FQCN=MediEco\\IliasUserOrchestratorOrbital\\Adapters\\Api\\HttpApi

ENV FLUX_ECO_DISPATCHER_SYNAPSE_FROM_HOST=medi-eco-ilias-user-orchestrator-orbital

ENV MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_EXCEL_IMPORT_PATH=/opt/medi-eco-ilias-user-orchestrator-orbital/data
ENV MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_DISPATCHER_CONFIG_ARCHIVE_PATH=NULL

COPY --chown=www-data:www-data ./app /opt/medi-eco-ilias-user-orchestrator-orbital/app

COPY --chown=www-data:www-data ./app/bin/medi-eco-ilias-user-orchestrator-orbital.install-libraries /usr/local/bin/medi-eco-ilias-user-orchestrator-orbital.install-libraries
RUN chmod a+rx /usr/local/bin/medi-eco-ilias-user-orchestrator-orbital.install-libraries

COPY --chown=www-data:www-data ./app/bin/medi-eco-ilias-user-orchestrator-orbital.import-all-force-subscriptions-updates /usr/local/bin/medi-eco-ilias-user-orchestrator-orbital.import-all-force-subscriptions-updates
RUN chmod a+rx /usr/local/bin/medi-eco-ilias-user-orchestrator-orbital.import-all-force-subscriptions-updates

USER root
RUN medi-eco-ilias-user-orchestrator-orbital.install-libraries

COPY ./app/cron/crontab /etc/crontab
RUN crontab /etc/crontab
RUN touch /var/log/cron.log
CMD crond -f

USER www-data
WORKDIR /opt/medi-eco-ilias-user-orchestrator-orbital/app

ENTRYPOINT ["sh", "./docker_entrypoint.sh"]