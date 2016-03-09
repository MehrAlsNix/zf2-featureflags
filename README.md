# zf2-featureflags

The zf2-featureflags module uses `qandidate-labs/qandidate-toggle` and act as a wrapper.

## Installation

```
 tbd
```

## Usage

```
 tbd
```

### Controller Plugin

```
if ($this->featureToggle()->isActive('featureA')) {
    // Your featureA code goes here.
}
```

### View Helper

```
<?php if ($this->featureToggle()->isActive('comments')) : ?>
    // Your comments code goes here.
<?php endif; ?>
```

### Tutorial

#### Using with ZF2

```
 tbd
```

#### Using with Zend Expressive

```
$ composer create-project zendframework/zend-expressive-skeleton expressive
```

For this tutorial we make an Zend based configuration and answers the install questions with:

1. n (full skeleton)
2. 3 (Zend Router)
3. 3 (Zend ServiceManager)
4. 3 (Zend View)
5. 1 (Whoops error handler for development)

After the installation step we can invoke our new application by

```
$ composer serve
```

which will create a php server on 0.0.0.0:8080.

Now we will add `mehr-als-nix/zf2-featureflags` to our `composer.json`

...
