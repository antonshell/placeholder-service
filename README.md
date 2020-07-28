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

3 . Set image size

[http://127.0.0.1:8000/img?width=500](http://127.0.0.1:8000/img?width=500) - 500x500
[http://127.0.0.1:8000/img?height=400](http://127.0.0.1:8000/img?height=400) - 400x400
[http://127.0.0.1:8000/img?width=320&height=240](http://127.0.0.1:8000/img?width=320&height=240) - 320x240

4 . Set custom text

[http://127.0.0.1:8000/img?text=Hello](http://127.0.0.1:8000/img?text=Hello)

5 . Set text size (default: 28)

[http://127.0.0.1:8000/img?width=800&text_size=40](http://127.0.0.1:8000/img?width=800&text_size=40)

6 . Set text color

[http://127.0.0.1:8000/img?color_text=000](http://127.0.0.1:8000/img?color_text=000)

7 . Set background color

[http://127.0.0.1:8000/img?color_bg=000](http://127.0.0.1:8000/img?color_bg=000)