# WordPress Plugin Framework

## Introduction

This is an OOP framework for making the development of WordPress plugins easier.

It simplifies the creation of custom post types, taxonomies, pages, and settings. It also includes a class for using a view model for displaying HTML output.

## Getting Started

### Composer

The package is hosted on [Packagist](https://packagist.org/packages/theantichris/wp-plugin-framework) and ready to be using with Composer. Just add package to your composer.json.

### Drop In

Move the files from the __theantichris/WpPluginFramework__ directory into your plugin and include them using include statements or namespacing.

## Creating WordPress Objects

### Custom Post Types

The CustomPostType class accepts optional arguments for post capabilities (array), post support (array), menu icon (string), and text domain (string). If a parameter is not specified it will be set to the WordPress defaults.

```
$newPostType = new CustomPostType($postTypeName, $capabilities = null, $supports = null, $menuIcon = null, $textDomain = "");
```

### Taxonomies

Taxonomies can be added to post types by creating a Taxonomy object. The $postTypes parameter is options and will use “post” if not specified, it will accept a string or array of strings.

```
$newTaxonomy = new Taxonomy($taxonomyName, $postTypes = null, $textDomain = "");
```

#### Terms

You can add terms to a Taxonomy object by using the addTerms() method. It accepts a single parameter that can either be a string or an array of strings.

```
$newTaxonomy->addTerms($terms);
```

### Pages

You can create new dashboard pages by using the MenuPage, ObjectPage, UtilityPage, SubMenuPage, and OptionsPage classes.

The only required fields are $pageTitle and $viewPath. The $parentSlug field is only required for the SubMenuPage class.

All pages use the View object to echo the HTML.

#### MenuPage

To add a top-level menu page use the MenuPage class.

```
$menuPage = new MenuPage($pageTitle, $viewPath, $capability = null, $menuIcon = null, $position = null, $viewData = array(), $parentSlug = null, $textDomain = '');
```

#### ObjectPage

ObjectPage adds a top-level page on the Object level (Posts, Media, Links, Pages, Comments, etc.)

```
$objectPage = new ObjectPage($pageTitle, $viewPath, $capability = null, $menuIcon = null, $position = null, $viewData = array(), $parentSlug = null, $textDomain = '');
```

#### UtilityPage

UtilityPage adds a top-level page on the Utility level ( Appearance, Plugins, Users, Tools, Settings, etc.)

```
$utilityPage = new UtilityPage($pageTitle, $viewPath, $capability = null, $menuIcon = null, $position = null, $viewData = array(), $parentSlug = null, $textDomain = '');
```

#### Removing Pages

You can remove a page using the remove_page( $page_slug ) method.

### View

There is a View class that provides to introduce some MVC functionality to the framework and make it simpler to create pages and other output.

To create a view place a PHP file that displays the HTML into the /views/ directory.

Assign the file name to $view_file. If you need to pass any data to the View assign it to an associative array to the $view_data property.

View::render() must be echoed.

```
echo View::render( $view_file, $view_data = null );
```

### Settings

You can create options for your plugin using the Settings class.

```
$setting = new Settings( $page_slug ); // Creates the settings object with the slug of the page. This could be a default page or one you create.
$setting->add_section( 'My Section', $view ); // Creates the settings section your options will be grouped under. The view will contain the header for the section.
$setting->add_field( 'My Field', $view ); // Creates the field and adds it to the section. The view needs to contain the input field for the option.
```

## Utilities

Some helper functions are included in the Utilities class. They are public, static functions so can be used anywhere.

### makeSingular()

Takes a plural string and makes it singular.

```
$singular_string = Utilities::make_singular( $plural_string );
```
