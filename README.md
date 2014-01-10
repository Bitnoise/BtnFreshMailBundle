BtnFreshMailBundle
==================

FreshMail api integration for symfony2

=============

### Step 1: Add BtnFreshMailBundle in your composer.json (private repo)

```js
{
    "require": {
        "bitnoise/freshmail-bundle": "dev-master",
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:Bitnoise/BtnFreshMailBundle.git"
        }
    ],
}
```

### Step 2: Enable the bundle

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Btn\FreshMailBundle\BtnFreshMailBundle(),
    );
}
```

### Step 3: Setup config

``` yml
# app/config/config/config.yml
# ...
# Btn fresh mail configuration
btn_fresh_mail:
    api_secret: api_secret
    api_key: api_key

```

### Step 4: Update your database schema

``` bash
$ php app/console doctrine:schema:update --force
```
