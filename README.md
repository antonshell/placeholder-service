# Placeholder service


There is a self hosted service for images placeholders generation.
Service works similar way as [https://placeholder.com/](https://placeholder.com/), but self hosted.

![SSH Deploy](https://github.com/antonshell/placeholder-service/workflows/SSH%20Deploy/badge.svg)
![Tests](https://github.com/antonshell/placeholder-service/workflows/Tests/badge.svg?branch=master)
![Code Coverage](https://raw.githubusercontent.com/antonshell/placeholder-service/master/.github/badges/coverage.svg)

Full code coverage report: [http://files.antonshell.me/github-actions/placeholder-service/master/coverage/coverage/](http://files.antonshell.me/github-actions/placeholder-service/master/coverage/coverage/)

Psalm html report: [http://files.antonshell.me/github-actions/placeholder-service/master/psalm/psalm-report.html](http://files.antonshell.me/github-actions/placeholder-service/master/psalm/psalm-report.html)

# Install locally

1 . Clone repository

```
git clone https://github.com/antonshell/placeholder-service.git
```

2 . Install dependencies

```
cd placeholder-service
composer install
```

3 . Run web server

```
php -S 127.0.0.1:8000 public/index.php
```

5 . Open in browser

[http://127.0.0.1:8000/](http://127.0.0.1:8000/) - Healthcheck

[http://127.0.0.1:8000/img](http://127.0.0.1:8000/img) - Default image

# Install in docker

1 . Clone repository

```
git clone https://github.com/antonshell/placeholder-service.git
```

2 . Run containers
```
docker-compose up
```

3 . Install dependencies

```
docker-compose exec php-fpm composer install
```

4 . Open in browser

[http://127.0.0.1:8000/](http://127.0.0.1:16880/) - Healthcheck

[http://127.0.0.1:16880/img](http://127.0.0.1:16880/img) - Default image

# Usage

1 . Healthcheck

[http://127.0.0.1:8000/](http://127.0.0.1:8000/)

2 . Get default image (300x300)

[http://127.0.0.1:8000/img](http://127.0.0.1:8000/img)

![300x300](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img.png)

3 . Set image size

- Set width
[http://127.0.0.1:8000/img?width=500](http://127.0.0.1:8000/img?width=500) - 500x500

![500x500](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_width=500.png)

- Set height
[http://127.0.0.1:8000/img?height=400](http://127.0.0.1:8000/img?height=400) - 400x400

![400x400](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_height=400.png)

- Set width & height
[http://127.0.0.1:8000/img?width=320&height=240](http://127.0.0.1:8000/img?width=320&height=240) - 320x240

![320x240](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_width=320_height=240.png)

4 . Set custom text

[http://127.0.0.1:8000/img?text=Hello](http://127.0.0.1:8000/img?text=Hello)

![custom text](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_text=Hello.png)

5 . Set text size (default: 28)

[http://127.0.0.1:8000/img?width=800&text_size=40](http://127.0.0.1:8000/img?width=800&text_size=40)

![text size](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_width=800_text_size=40.png)

6 . Set text color

[http://127.0.0.1:8000/img?color_text=000](http://127.0.0.1:8000/img?color_text=000)

![text color](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_color_text=000.png)

7 . Set background color

[http://127.0.0.1:8000/img?color_bg=000](http://127.0.0.1:8000/img?color_bg=000)

![text color](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_color_bg=000.png)

# Demo

[https://placeholder.antonshell.me/img?width=500](https://placeholder.antonshell.me/img?width=500)

# Tests

1 . Run tests

Local environment:
```
composer test
```

Docker environment:
```
docker-compose exec php-fpm composer test
```

2 . Update code coverage badges

Local environment:
```
composer update-badges
```

Docker environment:
```
docker-compose exec php-fpm composer update-badges
```

# Codestyle

1 . Fix codestyle

```
composer cs-fixer src
docker-compose exec php-fpm composer cs-fixer src
```

2 . Code quality with Psalm

```
composer psalm
composer psalm-report-html

docker-compose exec php-fpm composer psalm
docker-compose exec php-fpm composer psalm-report-html
```

Open in browser: psalm-report.html

# Macos docker environment(Mutagen)

1 . Install mutagen

```
brew install mutagen-io/mutagen/mutagen
mutagen daemon start
```

2 . Run containers

```
docker-compose down --remove-orphans || true
mutagen project start || mutagen project terminate
```

3 . Troubleshooting:

Fix permissions:
```
docker-compose exec php-fpm chmod -R 777 /var/www
```

Disable permission tracking:
```
git config core.fileMode false
```

# Setup xdebug (Docker)

[https://blog.denisbondar.com/post/phpstorm_docker_xdebug](https://blog.denisbondar.com/post/phpstorm_docker_xdebug)
