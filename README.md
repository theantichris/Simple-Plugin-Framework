# WordPress Plugin Framework

## Introduction

This is an OOP framework for making the development of WordPress plugins easier.

It simplifies the creation of custom post types, taxonomies, pages, and settings. It also includes a class for using a view model for displaying HTML output.

## Getting Started

### Composer

The package is hosted on [Packagist](https://packagist.org/packages/theantichris/wp-plugin-framework) and ready to be using with [Composer](https://getcomposer.org/). Just add package to your composer.json.

### Drop In

Move the files from the __theantichris/WpPluginFramework__ directory into your plugin and include them using `include` statements or namespacing.

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

All pages use the View class to echo the HTML.

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

#### OptionsPage

OptionsPage adds a sub-men page under Settings.

```
$optionsPage = new OptionsPage($pageTitle, $viewPath, $capability = null, $menuIcon = null, $position = null, $viewData = array(), $parentSlug = null, $textDomain = '');
```

#### SubMenuPage

SubMenuPage adds a page as a sub-menu item for another page. $parentSlug should contain the slug of the page to place the sub-page under.

```
$subMenuPage = new SubMenuPage($pageTitle, $viewPath, $capability = null, $menuIcon = null, $position = null, $viewData = array(), $parentSlug = null, $textDomain = '');
```

#### Removing Pages

You can remove a page using the removePage() method.

```
$page->removePage($pageSlug);
```

### Settings

You can create options for your plugin using the Settings class. The Settings class uses the View class to display output.

```
$setting = new Settings( $pageSlug ); // Creates the settings object with the slug of the page the settings should be on. This could be a default Dashboard page or one you create.
$setting->addSection( 'My Section', $view ); // Creates the settings section that your options will be grouped under. The view will contain the header for the section.
$setting->addField( 'My Field', $view ); // Creates a settings field and adds it to the settings section. The view needs to contain the HTML to display the form field for the option.
```

## View

The View class makes it simpler to display output from your plugin.

It allows you to take the code that displays the output and gives it its own file. Your output (or view) is separated from your logic keeping your code cleaner, easier to read, and easier to manage.

Create a directory in your project to hold all your view files.

Use the View class' render() static function to display the view and send any data the view needs to know about.

render() must be echoed in order to work.

```
$view = new View($viewFile, $viewData = null);
echo $view->render();
```

$viewFile should contain the full path and file name of the view file to render.

$viewData is used to pass data to the view if needed. It is an associated array. To use the data in the view file use a variable with the name of the data's key in the array. For example `$viewData['example']` will be `$example` in the view.

## Utilities

Some helper functions are included in the Utilities class. They are public, static functions so can be used anywhere.

### makeSingular()

Takes a plural string and makes it singular. Some WordPress object classes use it to automatically generate slugs.

```
$singular_string = Utilities::make_singular( $plural_string );
```
