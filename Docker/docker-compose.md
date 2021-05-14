## Summary:

## COMPOSE
```yaml
version: '3.8'

services:
  web:
    build:
      context: .
      dockerfile: Dockerfile
    command: sh -c "npm install && npm run dev"
    container_name: web
    ports:
      - "8080:80"
    volumes:
      - ./:/app
    environment:
      PASSWORD_FILE: /app/password.txt

  db:
    image: mongo:latest
    container_name: db
    volumes:
      - mongodb:/data/db
      - mongodb_config:/data/configdb
    ports:
      - 27017:27017
    command: mongod

volumes:
  mongodb:
  mongodb_config:
  
```
