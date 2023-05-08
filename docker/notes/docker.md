##TODO

- Look into customizations and parameters for common commands

## Pro-tips

- Use `.dockerignore` for excluding files from the image
- Create a separate target for running unit tests
- Denote relationships between containers with networks
- Use volumes for persistent data, binds for config sharing or development and
  tmpfs for sensitive or high performance tasks

## Summary:

- Copy `package.json` first to prevent reinstall of dependencies on code changes
- Prefer docker-compose to keep track of component's lifecycle
- Separate build and run steps into separate build stages (`FROM ...`)
- Use `FROM alpine:latest` instead of ubuntu (it is leaner)
- Use `--secret` to pass secrets
- Don't run as ROOT (create a non-root user and switch to it)
- Dockerfile tips:
  - Add `# syntax ...` as the first line
  - Include `LABEL maintainer=...`
  - Use `FROM alpine:...`
  - Define volumes with `VOLUME ...`
  - Use `WORKDIR` to simplify relative paths
  - Use `ENTRYPOINT` for greater control (and `docker-entrypoint.sh`)
  - Use `ADD` for untarring
  - `RUN`/`CMD` run during build/run respectively

```bash
docker run -it --rm --name test alpine vi
```

## Dockerfile

```bash
# syntax=docker/dockerfile:1
FROM node:latest

LABEL maintainer="Max Patiiuk <max@patii.uk>"

WORKDIR /code

ENV PORT 80

ENV NODE_ENV production

COPY ["package.json", "package-lock.json", "./"]

# By copying the dependency list first, changes to the code do not cause
# these to be reinstalled
COPY package.json /code/package.json

RUN npm install

COPY . /code

ENTRYPOINT ["node"]   # base command
CMD ["src/server.js"] # arguments for the base command
```

```bash
FROM node:latest as base

WORKDIR /code

COPY package.json package.json
COPY package-lock.json package-lock.json

FROM base as test
RUN npm ci
COPY . .
CMD [ "npm", "run", "test" ]
# or RUN npm run test
# RUN is executed during build
# CMD is executed during run

FROM base as prod
RUN npm ci --production
COPY . .
CMD [ "node", "server.js" ]
```

```bash
FROM alpine:latest

RUN apk add --no-cache vim
```

```bash
FROM ubuntu:latest

RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    mariadb-server \
  && rm -rf /var/lib/apt/lists/*

ADD archive.tar.gz /

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["mysql"]

# where docker-entrypoint.sh is:
#!/bin/bash
set -e
if [ "$1" = 'mysql' ]; then # intercept calls to `mysql`
  exec mysql "$@"
else
  exec "$@"
fi
```

```bash
# build
docker build --tag sample .
docker build --target test . # select the stage to build

# images
docker images # List of images

# ps
docker ps    # Get running containers
docker ps -a # Get all containers

# run
docker run sample --name name
docker run -p 8080:80 sample
docker run -d sample           # Detached
docker run -w /app sample      # Working directory
docker run -e LOGIN=maxxxxxdlp # Environmental variables

# start
docker start name

# stop
docker stop name

# rm
docker rm name
docker rm -f name # Force stop

# logs
docker logs name
docker logs name -f # Follow

# tag
docker tag sample maxxxxxdlp/sample

# push
docker push maxxxxxdlp/sample # Latest
docker push maxxxxxdlp/sample:v1.0.0

# rmi
docker rmi maxxxxxdlp/sample # Remove image

# pull
docker pull maxxxxxdlp/sample

# docker's rm -rf /
docker system prune --all --volumes --force

# attach to detached container
docker attach name
# to detach, press CTRL+p,q
```

## Multi-stage builds

```bash
FROM node AS build
WORKDIR /app
COPY . .
COPY --from=nginx:latest /etc/nginx/nginx.conf /nginx.conf
RUN npm build

FROM nginx
COPY --from=build /build /usr/local/app
```

## Volume

Volumes are defined using the `VOLUME path` directive in Dockerfile.

- named volume only accessible by containers preferred for production
  ```bash
  docker volume create disk (optional)
  docker run -v disk:/etc/disk sample
  docker volume inspect disk
  ```
- bind mounts specify the host's mountpoint preferred for development
  ```bash
  docker run -v /path:/etc/disk sample
  ```

## Network

```bash
docker network create net
docker run --network net --network-alias database sample
# network `net` would be accessible internally under `database`
```

## Security

Finish tasks that require ROOT first and then switch to non root:

```bash
RUN groupadd -r specify && useradd --no-log-init -r -g specify specify
USER specify
COPY --chown=specify:specify ./app/ /app/
```

## Secrets

```bash
FROM alpine
RUN --mount=type=secret,id=mysecret cat /run/secrets/mysecret
RUN --mount=type=secret,id=mysecret,dst=/sec cat /sec
# then:
docker build --secret id=mysecret,src=mysecret.txt .
```
