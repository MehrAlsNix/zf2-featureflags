# zf2-featureflags



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
