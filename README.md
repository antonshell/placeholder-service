# Placeholder service

There is a self hosted service for images placeholders generation.
Service works similar way as [https://placeholder.com/](https://placeholder.com/), but self hosted.

# Install

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

# Tests

```
php bin/phpunit
```

# Demo

[https://placeholder.antonshell.me/img?width=500](https://placeholder.antonshell.me/img?width=500)
