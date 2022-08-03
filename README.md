# Create a ranking image for ActionFreewar

## Setup

```bash
# Run
docker-compose up

# Visit
localhost:8200/images/afsrv-ranking.png
```

## Prod Setup

```bash
# Container
docker-compose -f docker-compose.prod.yml up -d --build

# Cronjob
*/5 * * * * docker exec af-image-ranking-php-prod php bin/generate-image.php > /dev/null 2>&1
```
