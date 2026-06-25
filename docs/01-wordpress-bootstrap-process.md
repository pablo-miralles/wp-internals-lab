## Before starting

To install and run WordPress, you need to fulfill some requirements. For 7.0 version, you will need:
- PHP 7.4 or greater
- MySQL 5.7 or MariaDB 10.3 or greater
- HTTPS support

We are taking for granted that you were able to install it sucessfully in the following explanations.

## The bootstrap process

In a PHP server, if there is no specific entry file configured, the server will try to run `index.php`.

When you install WordPress, you will notice there is a bunch of files, but let's open `index.php` to follow how the server would start reading and executing WordPress. That's what we call a bootstrap process.

## index.php

In `index.php` we find two important things:
- A define, that creates a constant. In this case, our WordPress installation `WP_USE_THEMES` is set to true.
- A require, that includes the code of the called file. The difference between include and require, is that require throw an error. In this case, `wp-blog-header.php` is loaded, so let's move to that file.

## wp-blog-header.php

Following the same principles, we find in this file two `require`, but this time the function used is `require_once`. It works the exact same, except the `require_once` will check if the file has been loaded before to load it just once.

The code we find, in order, is:
- require_once of `wp-load.php`.
- `wp()` function call, that sets up the WordPress Query.
- require_once of `/template-loader.php`, the file that decides which template will be shown in the frontend.

Time to check what is happening in `wp-load.php`

## wp-load.php

Here, the file lenght gets bigger. What we need to understand is:
- `ABSPATH` is defined here. The root of our WordPress installation.
- PHP `error_reporting` function. It is inside a `if function_exists` declaration because it can be disabled in php.ini
- If `wp-config.php` exists, then require it once.
- If not, call some files to start the installation process.

We were looking for the `wp-config.php` load here, so let's enter that file.

## wp-config.php

In `wp-config.php` we find:
- Some constant and variable definitions related to the database.
- If debug is enabled
- If ABSPATH is not defined, the possibility to define it here.
- Require once of the `wp-settings.php` file.

Let's move there.

## wp-settings.php

The `wp-settings.php` file is a big file too, that loads a lot of files, but we can simplify it in the following stages:

1. Minimum bootstrap and error handling: WordPress runs the minimum required files to start, checks its required version compared to the ones running in the sever, loads error handling, and the Plugin API (the WordPress API in charge of hooks, that enables actions and filters).
2. Then, sets up some server settings related to memory, debug, maintenance mode and cache and sets up the database.
3. Then loads most of the WordPress
4. Loads MU plugins, if its a multisite, network plugins, and then standard plugins. We can find here some `do_action`, to hook some code after each individual plugin is loaded. We also have `muplugins_loaded` hook when all MU and network ones are loaded, or `plugins_loaded`, after all the standard ones (so, all the plugins) are loaded.
5. Then, some global objets are initialized: `wp_the_query`, `wp_query`, `wp_rewrite`, `wp`, `WP_Widget_Factory` and `WP_Roles`.
6. Then, the `setup_theme` starts with a hook, that ends with the `after_setup_theme` hook. It's important to know that, between this two hooks, WordPress load the `functions.php` of the active theme.
7. Then we find `init` hook, where most of WordPress is already loaded. We normaly use this hook to add custom post types or custom taxonomies.
8. Finally, we find `wp_loaded`, that runs when WordPress is fully loaded.

## Summary of what is loaded in each hook

| hook | What is and is not loaded  |
|---|---|
| `muplugins_loaded` | Loaded: minimum bootstrap, error handling, Plugin API, server config, MU plugins and network plugin  |
| `plugins_loaded` | Loaded: Same as before + standard plugins. |
| `setup_theme` | Loaded: Same as before + initialized query, rewrite, widgets and role objets. Not loaded theme's function.php yet.  |
| `after_setup_theme` | Loaded: Same as before + theme's function.php + local objet. Note: WordPress is not fully loaded yet. |
| `init` | Loaded: WordPress finished loading, but headers and not sent yet. Custom hooks and taxonomies are usually hooked here.  |
| `wp_loaded` | Loaded: WordPress and plugins are fully loaded here. Not loaded: The query. |
| `wp` | Loaded: WordPress, plugins and the query. We can use is_something (frontpage, page, singular, etc) here. |
| `template_redirect` | Loaded: Same as before, but it's the last moment before choosing what template or route to show. |

## Request > hook > render explanation

Hooks allow developers to modify how WordPress works in certain points of the execution, without editing the source code and the core files, as they are updated with each update.

We have several: when each plugin is loaded, before or after the theme setup, when almost all WordPress is loaded but headers are not sent (init), or when it is fully loaded.

The dev can add actions or remove them from the hook, with the add_action or remove_action functions, and also create their own using the do_action function.

There is another type of hook called filters. They work similar to actions, but its key difference is that they must return something, as they are used to modify data at a certain point.

## Diagram

```
request
	↓
index.php
	↓
wp-blog-header.php
	↓
wp-load.php
	↓
wp-config.php
	↓
wp-settings.php
	↓
[We keep loading wp-blog-header.php]	
wp()
	↓
template-loader.php
```

and then, hooks order:

```
muplugins_loaded
	↓
plugins_loaded
	↓
setup_theme
	↓
theme's function.php
	↓
after_setup_theme
	↓
init (WordPress core loaded, not query)
	↓
wp_loaded (WordPress and plugins fully loaded, not query yet)
	↓
[From now, only in front] wp (WordPress, plugins and query, loaded)
	↓
template_redirect (WordPress, plugins and query loaded, last moment before choosing template or route)
```