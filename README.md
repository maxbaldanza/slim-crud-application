A base CRUD application using SLIM, twig and bootstrap
# Setup

## Install dependencies

```bash
npm install
```

## Docker

```bash
docker-compose up
```

## Database

```
docker-compose exec web bash
./bin/doctrine orm:schema:create
```

# Assets
Assets are built using gulp:
```bash
gulp
```
