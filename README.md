# Rss Pipes

Rss feeds manipulating tool inspired by Yahoo Pipes. It has no pipes editing interface - you just configure them in `.yml` files and copy their urls to your reader.

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

## Available sections

### Rss

Parses rss feed.

### Atom

Parses atom feed.

### Filter

Keep only items that fulfill the condition.

### Block

Drop items that fulfill the condition.

### Callback

Proces feed or items using callbacks.

### Replace

Replaces substring inside attribute.

Parameters:

* **attribute** - attribute we want to replace substring in.
* **search** - subtring we want to replace.
* **replace** - subtring we want to replace with.

Sample:

```yaml
-
  type: replace
  attribute: title
  search: space
  replace: spaaace
```

### Pipe

Runs separate pipe and adds it's result to feed.
