# zf2-featureflags

[![Build Status](https://scrutinizer-ci.com/g/MehrAlsNix/zf2-featureflags/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/MehrAlsNix/zf2-featureflags/build-status/develop) [![Code Coverage](https://scrutinizer-ci.com/g/MehrAlsNix/zf2-featureflags/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/MehrAlsNix/zf2-featureflags/?branch=develop) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/MehrAlsNix/zf2-featureflags/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/MehrAlsNix/zf2-featureflags/?branch=develop)

The zf2-featureflags module uses `qandidate-labs/qandidate-toggle` and act as a wrapper.

## Installation

```
 tbd
```

## Example config

```
    'zf2_featureflags' => [
        'qandidate_toggle' => [
            'persistence' => 'ToggleFeature\InMemory'
        ],
        'features' => [
            'some-feature' => [
                'name' => 'disabled',
                'conditions' => [],
                'status' => 'inactive',
            ],
            'some-other' => [
                'name' => 'enabled',
                'conditions' => [],
                'status' => 'always-active'
            ]
        ]
    ]
```

## Usage

### Controller Plugin

```
if ($this->featureToggle()->isActive('some-feature')) {
    // Your featureA code goes here.
}
```

### View Helper

```
<?php if ($this->featureToggle()->isActive('some-other')) : ?>
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
