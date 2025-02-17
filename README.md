# Monitoring database with postgres_exporter

## Docker Compose
### Start
```shell
docker-compose --project-name="hospital" up -d
```

### Stop
```shell
docker-compose --project-name="hospital" down
```

## Access to PgAdmin
Open in browser [http://localhost:5050](http://localhost:5050)

## Подключение Xdebug в PhpStorm

1. Откройте **File -> Settings -> PHP -> Servers**.
2. Добавьте сервер с именем `docker`:
    - **Host:** `localhost`
    - **Port:** `80`
    - **Debugger:** `Xdebug`
3. Установите галочку **Use path mappings** и укажите путь:

   ```
   <твой-путь-на-хосте>/project__name/src -> /var/www/html
   ```


