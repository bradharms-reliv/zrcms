Command Line
============

## Simple Import Steps ##

1) In MySQL workbench, run the SQL command "set foreign_key_checks=0;" then select all zrcms_* tables and right click and "drop tables"

2) In an IDE, turn RCM-compat OFF and ZRCMS ON in config/_server-environment/local-override.php

3) Run these bash commands:
```bash
cd /www/vagrant-web
vagrant ssh
cd /www/web
ENV="local" bin/console orm:schema-tool:update --force
ENV="local" bin/console rcm:export --file ./data/rcm-data.json
ENV="local" bin/console zrcms:import --file ./data/rcm-data.json 

```

4) In an IDE, turn RCM-compat ON and ZRCMS ON in config/_server-environment/local-override.php

## Advanced usage ##

Doctrine Dump:

```
ENV="local" bin/console orm:schema-tool:update --dump-sql > ./data/0.0.0.sql
```

Doctrine Schema Update:

``` 
#Turn RCM compat OFF first!
ENV="local" bin/console orm:schema-tool:update --force
```

Exporting from RCM:

``` 
#Turn RCM compat OFF first!
ENV="local" ./bin/console rcm:export --file ./data/rcm-data.json

# OR limit to a list of siteIds:
ENV="local" ./bin/console rcm:export --file ./data/rcm-data.json --siteIds "[1,3,10,21,1065]"

# OR with more options:
# ENV="local" ./bin/console rcm:export --file ./data/rcm-data.json --limit 100 --pp 1
```

Importing to ZRCMS:

```
ENV="local" ./bin/console zrcms:import --file ./data/rcm-data.json 
```
