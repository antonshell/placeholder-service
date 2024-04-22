# Placeholder service

There is a self-hosted service for images placeholders generation.
Service works similar way as [https://placeholder.com/](https://placeholder.com/), but self-hosted.

![SSH Deploy](https://github.com/antonshell/placeholder-service/workflows/SSH%20Deploy/badge.svg)
![Tests](https://github.com/antonshell/placeholder-service/workflows/Tests/badge.svg?branch=master)
![Code Coverage](https://raw.githubusercontent.com/antonshell/placeholder-service/master/.github/badges/coverage.svg)

# Install in docker

1 . Clone repository

```
git clone https://github.com/antonshell/placeholder-service.git
```

2 . Run containers

```
cd placeholder-service
docker-compose up
```

3 . Install dependencies

```
docker-compose exec php-fpm composer install
```

4 . Open in browser

[http://127.0.0.1:16880/](http://127.0.0.1:16880/) - Healthcheck

[http://127.0.0.1:16880/img](http://127.0.0.1:16880/img) - Default image

# Demo

There is a SaaS version available:
[https://placeholder.antonshell.me/img?width=500](https://placeholder.antonshell.me/img?width=500)

And also UI available:
[https://placeholder-ui.antonshell.me/](https://placeholder-ui.antonshell.me/)

![placeholder-ui](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/ui_demo/placeholder-ui.png)

There is a separate project:
[https://github.com/antonshell/placeholder-service-ui](https://github.com/antonshell/placeholder-service-ui)

# Usage

1 . Healthcheck

[https://placeholder.antonshell.me/](https://placeholder.antonshell.me/)

2 . Get default image (300x300)

[https://placeholder.antonshell.me/img](https://placeholder.antonshell.me/img)

![300x300](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img.png)

3 . Set image size

- Set width
[https://placeholder.antonshell.me/img?width=500](https://placeholder.antonshell.me/img?width=500) - 500x500

![500x500](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_width=500.png)

- Set height
[https://placeholder.antonshell.me/img?height=400](https://placeholder.antonshell.me/img?height=400) - 400x400

![400x400](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_height=400.png)

- Set width & height
[https://placeholder.antonshell.me/img?width=320&height=240](https://placeholder.antonshell.me/img?width=320&height=240) - 320x240

![320x240](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_width=320_height=240.png)

4 . Set custom text

[https://placeholder.antonshell.me/img?text=Hello](https://placeholder.antonshell.me/img?text=Hello)

![custom text](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_text=Hello.png)

5 . Set text size (default: 28)

[https://placeholder.antonshell.me/img?width=800&text_size=40](https://placeholder.antonshell.me/img?width=800&text_size=40)

![text size](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_width=800_text_size=40.png)

6 . Set text color

[https://placeholder.antonshell.me/img?color_text=000](https://placeholder.antonshell.me/img?color_text=000)

![text color](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_color_text=000.png)

7 . Set background color

[https://placeholder.antonshell.me/img?color_bg=000](https://placeholder.antonshell.me/img?color_bg=000)

![text color](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img_color_bg=000.png)

8 . Set format (PNG, JPEG, GIF)

[https://placeholder.antonshell.me/img?format=png](https://placeholder.antonshell.me/img?format=png)

![PNG](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img.png)

[https://placeholder.antonshell.me/img?format=jpeg](https://placeholder.antonshell.me/img?format=jpeg)

![JPEG](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img.jpeg)

[https://placeholder.antonshell.me/img?format=gif](https://placeholder.antonshell.me/img?format=gif)

![GIF](https://raw.githubusercontent.com/antonshell/placeholder-service/master/resources/test_images/img.gif)

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

Full code coverage report: [http://files.antonshell.me/github-actions/placeholder-service/master/coverage/coverage/](http://files.antonshell.me/github-actions/placeholder-service/master/coverage/coverage/)

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

Psalm html report: [http://files.antonshell.me/github-actions/placeholder-service/master/psalm/psalm-report.html](http://files.antonshell.me/github-actions/placeholder-service/master/psalm/psalm-report.html)

# Composer require checker

```
wget https://github.com/maglnet/ComposerRequireChecker/releases/download/4.10.0/composer-require-checker.phar
docker-compose exec php-fpm composer require-check
```

More details: [https://github.com/maglnet/ComposerRequireChecker](https://github.com/maglnet/ComposerRequireChecker)

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
