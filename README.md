![Build Status](https://github.com/thecodezone/dt-oikos/actions/workflows/ci.yml/badge.svg?branch=master)

# Disciple.Tools - Plugin

__Kick start your Disciple.Tools plugin project with this template!__

This plugin is a modern, opinionated plugin starter template inspired by Laravel.

> **Tip:** You can safely delete this README.md file and replace it with your own. You can always view this readme
> at [github.com/thecodezone/dt-oikos](https://github.com/thecodezone/dt-oikos).

## Purpose

At CodeZone, we recognize a developer or team might love Disciple.Tools, but __miss the modern tooling found in PHP
Application frameworks.__

There growing community of Laravel and Symfony developers who bring exceptional expertise to the table.

Our purpose is to bridge the gap between these seasoned developers and the dynamic environment of Disciple.Tools.
We strive to make Disciple.Tools plugin development not only accessible but also a delightful experience for those
already well-versed in Laravel and Symfony frameworks.

> **Are you a WordPress developer?** You may feel more at home using
> the [Disciple Tools Starter Template](https://github.com/thecodezone/dt-oikos/).

## Included

### Framework

1. WordPress code style requirements. ```phpcs.xml```
1. PHP Code Sniffer support (composer) @use ```/vendor/bin/phpcs``` and ```/vendor/bin/phpcbf```
1. GitHub Actions Continuous Integration ```.githbub/workflows/ci.yml```
1. Disciple.Tools Theme presence check. ```\DT\Test\plugin()->is_dt_theme(); ```
1. Remote upgrade system for ongoing updates outside the Wordpress Directory.
1. Multilingual support. ```/languages``` & ```default.pot```
1. [Composer](https://getcomposer.org/) support. ```composer.json```
1. Scoped dependency autoloading using [PHPScoper](https://github.com/humbug/php-scoper). ```/composer.scoped.json```
1. Laravel-style service providers. ```/src/Providers```
1. Laravel-style controllers. ```/src/Controllers```
1. Vite build system. ```/vite.config.js``` & ```/resources/js```
1. Inversion of control container
   using [Laravel's Service Container](https://laravel.com/docs/master/container#main-content). ```/src/Container.php```
1. Routing system using [FastRoute](https://github.com/nikic/FastRoute). ```/routes/web.php```
1. Conditional routes, route groups, and request middleware provided
   by [CodeZone Router](https://github.com/thecodezone/wp-router).
1. View layouts, partials, and escaping provided by the plain PHP templating engine, [Plates](https://platesphp.com/).
1. Validation provided by [Laravel's Validation](https://laravel.com/docs/master/validation#available-validation-rules).

### Components

1. Sample admin menu and admin page with starter tabs component.
1. Sample custom post type.
1. Sample REST api.
1. Sample magic link.

> **Tip:** This starter plugin does not attempt to provide every component provided by
> the [Disciple Tools Starter Template](https://github.com/thecodezone/dt-oikos/). See
> the [Disciple Tools Starter Template](https://github.com/thecodezone/dt-oikos/) for
> implementation examples of charts, tiles and other components.

### Getting Started

1. Clone this repository.
1. Remove the .git folder and initialize a new git repository.
1. Edit the `.rename.sh` updating each variable to match your plugin.
1. Run `./.rename.sh`
1. Edit `composer.json` to update the `name`, `description`, and `author` fields.
1. Replace the `DT//Plugin` namespace with your namespace in the `composer.json` `autoload` and `extra.wpify-scoper`
   sections.
1. Edit `package.json` to update the `name` and `description` fields.
1. Edit `version-control.json` with your plugin information.
1. Run `composer install` to install PHP dependencies.
1. Run `npm install` to install JS dependencies.
1. Run `npm run dev` to compile assets for development.
1. Commit and push your changes a new GitHub repository.
1. Open the WordPress admin and activate your plugin.

#### Scoped Dependency Autoloading

This plugin uses [Composer](https://getcomposer.org/) to manage dependencies. The plugin's dependencies are scoped to
your plugin's namespace. This means you can use any package you want without worrying about conflicts with other
plugins. For example, if you want to use the [Guzzle](http://docs.guzzlephp.org/en/stable/) HTTP client, you can simply
add it to your `composer.scoped.json` file, instead of the `composer.json` file.
Guzzle would then be installed in the `vendor-scoped` directory, instead of the `vendor` directory. This allows you to
use Guzzle without worrying about conflicts with other plugins that may also use Guzzle.
See [PHPScoper](https://github.com/humbug/php-scoper) for more information.

#### Multilingual Support

WordPress's [Internationalization](https://developer.wordpress.org/themes/functionality/internationalization/)
functionality and [Weblate](https://weblate.org/en/) via [translate.disciple.tools](https://translate.disciple.tools/)
are used to provide multilingual support.

Hard-coded strings should be wrapped in the `__()` function. For example:

```php
__( 'Hello World!', 'dt-oikos' );
```

#### Service Providers

Service providers are used to register services into the
plugin's [inversion of control container](https://laravel.com/docs/master/container#main-content) or with
Disciple.Tools. Service providers are located in the `src/Providers` directory. The `register()` method is called when
the plugin is first loaded. The `boot()` method is called after the theme have been loaded.

Register new service providers in `/src/Providers/PluginServiceProvider.php`.

```php
namespace DT\Test\Providers;

use DT\Test\Plugin;

class ExampleServiceProvider extends ServiceProvider
{
    /**
     * Called when the plugin is first loaded.
     *
     * @return void
     */
    public function register()
    {
        // Register a service into the plugin's container.
        $this->container->bind( 'example', function () {
            return new Example();
        } );
        
        add_filter( 'some/filter', function () {
           //some filter
        });
    }

    /**
     * Called when the theme is loaded.
     *
     * @return void
     */
    public function boot()
    {
        add_action( 'some/action', function () {
            //Some action
        });
    }
}

```

#### Routing

Routing is handled by [CodeZone Router](https://github.com/thecodezone/wp-router). Routes are located in
the `routes/web` file. Read more about routing in the [CodeZone Router](https://github.com/thecodezone/wp-router)
documentation.

#### Controllers

Controllers are located in the `src/Controllers` directory. Controllers are responsible for handling requests and
returning responses. Controllers are basic PHP classes with no parent class or base controller. Controllers are resolved
from the container using the controller's fully qualified class name. Controllers can be resolved from the container to
make use of automatic dependency injection.

> **Tip:** Keep your controllers thin. Business logic should be moved to services. Controllers should only be
> responsible for handling requests and returning responses. Anything more than basic logic should be moved to a
> service.

##### Validation

The Illuminate validator can be used to validate requests.
See [Laravel Rules](https://laravel.com/docs/master/validation#available-validation-rules).

##### Example Controller

```php
<?php

namespace DT\Oikos\Controllers\Admin;

use DT\Oikos\Illuminate\Http\RedirectResponse;
use DT\Oikos\Illuminate\Http\Request;
use DT\Oikos\Illuminate\Http\Response;
use function DT\Oikos\transaction;
use function DT\Oikos\validate;
use function DT\Oikos\view;


class ExampleController {
	/**
	 * A GET route should map to this method via [ExampleController::class, 'show'].
	 */
	public function show( Request $request, Response $response ) {
		return view( "example", [
		    'option1' => get_option( 'option1' ),
		    'option2' => get_option( 'option2' ),
		] );
	}

	/**
         * A POST route should map to this method via [ExampleController::class, 'update'].
         */
	public function update( Request $request, Response $response ) {
		$error = false;

		// Add the settings update code here
		$errors = validate( $request->all(), [
			'option1' => 'required',
			'option2' => 'required',
		] );

		if ( count( $errors ) > 0 ) {
			$error = __( 'Please complete the required fields.', 'dt-oikos' );
		}

		if ( ! $error ) {
			//Perform update in a MYSQL transaction
			$result = transaction( function () use ( $request ) {
				set_option( 'option1', $request->post( 'option1' ) );
				set_option( 'option2', $request->post( 'option2' ) );
			} );

			if ( $result !== true ) {
				$error = __( 'The form could not be submitted.', 'dt-oikos' );
			}
		}


		if ( $error ) {
			return new RedirectResponse( 302, admin_url(
					'/dt/oikos/example/?' . http_build_query( [
						'error'  => $error,
						'fields' => $errors,
					] )
				)
			);
		}

		return new RedirectResponse( 302, admin_url( '/dt/oikos/example/?&updated=true' ) );
	}
}
```

#### Templating

Templating is provided by the plain PHP templating engine, [Plates](https://platesphp.com/).
The template service located at `src/Services/Template.php` is used to bootstrap a blank template for your plugin.
Routes are mapped to controllers which load basic PHP templates from the `resources/views` directory.

> **Tip:** Be sure to use WordPress escaping functions when outputting data in your templates.
> See [Data Validation](https://developer.wordpress.org/themes/theme-security/data-sanitization-escaping/) for more
> information.

##### Loading a view inside of the plugin template

```php
    use DT\Test\view;
    
    template( 'hello', [
        'name' => 'World',
    ] );
```

##### Loading a without the plugin template

```php
    use DT\Test\view;
    
    view( 'hello', [
        'name' => 'World',
    ] );
```

#### Magic Links

A basic user-based magic link is provided. See
the [DT starter plugin template](https://github.com/DiscipleTools/disciple-tools-plugin-starter-template/tree/master/magic-link)
for more examples, like contact and object magic links. To utilize magic links, you must first uncomment the magic link
service provider in the `providers` array in `/src/Providers/PluginServiceProvider`.

```php
protected $providers = [
		ViewServiceProvider::class,
		ConditionsServiceProvider::class,
		MiddlewareServiceProvider::class,
		//AdminServiceProvider::class,
		//PostTypeServiceProvider::class,
		MagicLinkServiceProvider::class,
		RouterServiceProvider::class,
	];
```

#### Post Types

A dt post type is included. To utilize post types, you must first uncomment the post type service provider in
the `providers` array in `/src/Providers/PluginServiceProvider`.

```php
protected $providers = [
		ViewServiceProvider::class,
		ConditionsServiceProvider::class,
		MiddlewareServiceProvider::class,
		//AdminServiceProvider::class,
		PostTypeServiceProvider::class,
		//MagicLinkServiceProvider::class,
		RouterServiceProvider::class,
	];
```

#### Code Style

[PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) (`phpcs`) is used for static code analysis
and [PHP_CodeSniffer Beautifier](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Usage-Advanced#fixing-errors-automatically) (`phpcbf`)
for automatic code formatting. Before committing your code, run the following commands to check and fix coding
standards:

```bash
/vendor/bin/phpcs
/vendor/bin/phpcbf
```

> PHP_CodeSniffer and Beautifier work best when integrated with your IDE.
> See [PHPSTORM](https://www.jetbrains.com/help/phpstorm/using-php-code-sniffer.html)
> and [VSCode](https://marketplace.visualstudio.com/items?itemName=ValeryanM.vscode-phpsab) for more information.

##### Integration with your IDE

#### Testing

This plugin uses [PHPUnit](https://phpunit.de/) for testing. Tests are located in the `test` directory.

Before running tests you must install a local version of WordPress to test against using `tests/install-wp-tests.sh`.
Here is an example using ddev database credentials:

1. Create an empty database for testing.

```bash
ddev mysql; 
create database testing;
exit;
```

2. Run `ddev describe` to get your database credentials.

3. Run the `tests/install-wp-tests.sh` script with your ddev database credentials.

```bash
tests/install-wp-tests.sh testing db db 127.0.0.1:32770
```

4. Run the tests.

```bash
vendor/bin/phpunit
```

> **Note** Phpunit 10.0.0 is not compatible with WP testing. PHPUnit 9 is installed as a dependency. If you would rather
> use your global PHPUnit, make sure to use version 9 or below.

### Example Test

```php
/**
 * @test
 */
public function example_http_test() {
    $response = $this->post( 'dt/oikos/api/page', ['someField' => 'value'], [
        'X-WP-Nonce' => wp_create_nonce( 'dt_oikos' ),
    ] );

    $this->assertEquals( 200, $response->getStatusCode() );
}
```

## Recommended

- Disciple.Tools Theme installed on a local Wordpress
  Server [DDEV](https://ddev.readthedocs.io/en/latest/users/quickstart/#wordpress)
  or [localwp.com](https://localwp.com).

## Contribution

Contributions welcome. You can report issues and bugs in the
[Issues](https://github.com/thecodezone/dt-oikos/issues) section of the repo. You can
present ideas
in the [Discussions](https://github.com/thecodezone/dt-oikos/discussions) section of the
repo. And
code contributions are welcome using
the [Pull Request](https://github.com/thecodezone/dt-oikos/pulls)
system for git. For a more details on contribution see the
[contribution guidelines](https://github.com/thecodezone/dt-oikos/blob/master/CONTRIBUTING.md).
