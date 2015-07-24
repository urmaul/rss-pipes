# Rss Pipes
Rss feeds manipulating tool inspired by Yahoo Pipes.

## Usage

### Simplest app

Just create `index.php` file with content like this.

```php
<?php

require '../vendor/autoload.php';

$pipesDir = __DIR__ . '/../pipes';
\rsspipes\View::run($pipesDir);

```

Then you create a `pipes` dir that contains your pipe configs. For example you can create a config named `urmaul.yml` with content like this.

```yaml
# urmaul.com without yii
---
-
  type: atom
  url: http://urmaul.com/atom.xml
-
  type: block
  rules:
    title: Yii
```

Opening `index.php?pipe=urmaul` you will see rss feed of urmaul.com blog without posts about Yii.
