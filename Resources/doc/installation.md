# Installation

## Download the Bundle

Require the bundle in your `composer.json` file:

``` bash
$ composer require egeloen/form-extra-bundle
```

## Register the Bundle

Then, update your `app/AppKernel.php`:

``` php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Ivory\FormExtraBundle\IvoryFormExtraBundle(),
            // ...
        );

        // ...
    }
}
```

You're done, the bundle is ready to be used!
