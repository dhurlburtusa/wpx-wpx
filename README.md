# WPX

The WordPress eXtension library "extends" WP by functions and classes to help make building plugins and themes easier.


## Usage

`Wpx` uses major version sub-namespaces (see the FAQ to find out why).

There are many different ways you can use `Wpx` given its version sub-namespace. The following demonstrates how to call `WpConfig::configure` four different ways.

**Using fully-qualified namespaces**

```php
Wpx\Wpx\v0\WpConfig::configure( ... );
// Or
\Wpx\Wpx\v0\WpConfig::configure( ... );
```

**Using a namespace alias**

```php
use Wpx\Wpx\v0 as Wpx;

Wpx\WpConfig::configure( ... );
```

**Import Class**

```php
use Wpx\Wpx\v0\WpConfig;

WpConfig::configure( ... );
```

**Import Class with an Alias**

```php
use Wpx\Wpx\v0\WpConfig as Config;

Config::configure( ... );
```


## FAQ

- Q. Why are is there a version namespace? This doesn't seem to be commonly done.

  A. Reusable code in the WordPress environment presents a unique challenge. When WordPress processes a request the code shares the same namespace. Fortunately PHP 5.3.0 introduced namespaces. This helps keep name collisions to a minimum. But many libraries are designed to use the same namespace, even between different versions of the same library. In WordPress version 1.2, plugins were introduced. This gave plugin developers to include whatever PHP code they wanted including third-party libraries. Back before PHP added namespaces to the language, it was customary for each plugin to prefix each of their functions, classes, constants, etc (we'll refer to them as members in the remainder of this answer) with something likely not to collide with an existing plugin or other PHP code.

  A problem can arise when two different plugins wish to use the same library. Different versions of the same library are not always compatible with each other. In many cases it is due to the fact that each version of the library uses the same PHP namespace or the members have the same name. Therefore, both cannot be loaded into PHP at the same time. So, when different plugins try to load the same library, PHP will throw an error stating that you can't re-define the same member. To avoid this error, most library authors first check whether something their library defines has already been defined. If it has, then it is assumed that the library was already loaded earlier in the request and won't try to load the library.

  If two plugins both depend on the same library with the exact same version (they will both have a copy within their plugin directory), then as long as the library was designed to only load if it doesn't already exist, then everything should be fine. Which ever plugin loads first will load the library. When the other plugin loads, it will try to load the same library but the library will check first to see if the library was already loaded. The library will then skip loading itself a second time.

  But if two plugins both depend on the same library but with different versions, then there _may_ be problems. It will depend on the exact scenario. Let's take a look at those different scenarios.

  **Scenario 1: Same major and minor version but different patch version**

  As long as neither plugin actually relies upon the change (usually a bug fix) in the different patches, then everything should be fine. That is, it shouldn't matter which plugin loads the library since either is compatible with the plugin code.

  But if at least one of the plugins relies upon the bug fix in their version of the library, then there will be an issue if their version of the library is not loaded first. The order in which the plugins load depends on the order in which WordPress loads them. WordPress doesn't guarantee a particular order in which the plugins are loaded. (Currently, it depends on the order in which the `wp_get_active_and_valid_plugins` function returns the plugins which depends on the order it is saved in the database. Every time WordPress activates a plugin, it sorts the plugins alphabetically by directory and filename and saves it in the database. But many plugins are known to or at least are capable of changing the order the plugins are loaded.)

  For example, if Plugin A and Plugin B both depend on library X but Plugin A needs library X 1.0.0 or better and Plugin B needs library X 1.0.1 or better, then there will be a problem if Plugin A is loaded first. When Plugin A loads, it will load library X 1.0.0 first. When Plugin B loads, then library X 1.0.1 won't load.

  If the plugins loaded in a different order, then library X 1.0.1 will be loaded first. Everything should be fine assuming correct semantic versioning. (If you are not familiar with semantic versioning, please see [semver.org](https://semver.org/).)

  **Scenario 2: Different major versions**

  In this scenario, if the libraries from the two plugins use the same namespace, without a version sub-namespace, then there is a very high probability that the plugins will fail since only one version of the library can be loaded when the same namespace is used. However, if the libraries were designed to use a different namespace for each version, then both versions of the library can be loaded at the same time. This will consume a bit more memory but the plugins will continue to work.

  You may be thinking, then "use a different namespace for every single version of the library, then there will never be a collision." While that is true, a balance needs to be made between resource consumption and avoiding every single possible collision.

  Imagine the scenario where you have ten plugins that each depend on the same library but different versions (could only be differences in the patch version or could be as extreme as differences in the major version). Then each version of the library will be loaded, thereby consuming much more resources than probably necessary. If the library is correctly following semantic versioning, then the only time each plugin would have to load its own copy of the library is when all versions have a different major version. This is an unlikely scenario – possible but unlikely. Could have a couple or a few versions of the same library with different major versions.

  So, Wpx has chosen to only use a version sub-namespace for the major version. Then the latest version of any given major version will be compatible with any other earlier version in that same major version. A problem could arise if an earlier version of the same major version is loaded first due to the order different plugins load. However, there is a work around. The WordPress developer could force the latest version of the given major version to be loaded first. An ideal way to do that is to load it in a must-use plugin.

  **Scenario 3: Same major but different minor versions**

  This is similar to scenario 1. All should be fine if the latest version of library is loaded first.

  The collision issue described here doesn't seem to be super prevalent. What's special about `Wpx` that justifies is use of the version sub-namespace?

  `Wpx` is designed to make plugin and theme development easier. With that goal in mind, the odds that different plugins and/or themes will be using different versions of `Wpx` is higher than non-WordPress specific plugins. So, in order to ensure you never run into scenario 2, `Wpx` will use different version sub-namespaces for different major versions of the library.
