# WordPress Plugin Framework

## Introduction

This is an OOP framework for making the development of WordPress plugins easier and more strongly typed.

Each WordPress Object in the framework handles the WordPress specific registration functions and ties those functions to the right hooks automatically so a use only needs to set up properties and create the object.

## Getting Started

### Composer

The package is hosted on [Packagist](https://packagist.org/packages/theantichris/wp-plugin-framework) and ready to be using with [Composer](https://getcomposer.org/). Just add package to your composer.json.

### Drop In

Move the files from the __theantichris/WpPluginFramework__ directory into your plugin and include them using `include` statements.

### Using the Framework in Your Plugin

The easiest way to start using the frame work is to create a class for your plugin and place the framework code in the classes constructor.


    class myPlugin
    {
        public function __construct()
        {
            // Place framework code in there.
        }
    }

    new myPlugin();

## Creating WordPress Objects

This framework contains classes for creating post types, taxonomies, pages, and settings. These classes all inherit from the WordPressObject class.

### WordPressObject

The WordPressObject class provides some common methods the other classes use and a static property for defining your text domain. This is an abstract class and cannot be instantiated.

#### Text Domain

To specify the text domain for your plugin set the static property $textDomain on the WordPressObject class. This is optional, the text domain has a default value of 'default'.

    WordPressObject::$textDomain = 'my-text-domain';

#### makeSingular()

The makeSingular() method takes a word as a string and returns the singular version of the word. The PostType and Taxonomy classes use this to generate labels. This is a protected method and gets called automatically where it is needed.

#### getSlug()

This public method passes an object's $name property through the WordPress [sanitize_title()](http://codex.wordpress.org/Function_Reference/sanitize_title) function and returns that value.

    echo $someObject->getSlug();

### Post Types

The PostType class constructor requires the name of the post type to be created. The name must be plural for the labels to be generated correctly.

The PostType class constructor generates the labels for the post type and then ties the [register_post_type()](http://codex.wordpress.org/Function_Reference/register_post_type) function to the [init](http://codex.wordpress.org/Plugin_API/Action_Reference/init) hook.

    $postType = new PostType('My Post Type');

The rest of the properties for PostType have defaults set to create a basic, publicly facing post type but can be overridden using setters.

#### setDescription()

The setDescription() method accepts a string. Default: null

    $postType->setDescription('This is my custom post type.');

#### setPublic()

The setPublic() method accepts a bool. This determines if the post type shows in the Dashboard and front end of the site. Default: true

    $postType->setPublic(false);

#### setMenuPosition()

The setMenuPosition() method accepts an integer or numeric string. The higher the number, the higher the post type's menu item is in the Dashboard. If you specify a value taken by another menu item one might override the other. Default: null

    $postType->setMenuPosition(85);

or...

    $postType->setMenuPosition('85');

#### setMenuIcon()

The setMenuIcon() method accepts an image URL or [dashicon](http://melchoyce.github.io/dashicons/) as a string. Default: null

    $postType->setMenuIcon('http://placehold.it/15x15');

or...

    $postType->setMenuIcon('dashicons-admin-tools');

#### setCapabilities()

The setCapabilities() method accepts a string array of the capabilities for managing the post type.

The included Capabilities class can be used to make sure valid WordPress capabilities are used.

Default:

    array(
        'edit_post'          => Capability::edit_posts,
        'read_post'          => Capability::read_posts,
        'delete_post'        => Capability::delete_posts,
        'edit_posts'         => Capability::edit_posts,
        'edit_others_posts'  => Capability::edit_others_posts,
        'publish_posts'      => Capability::publish_posts,
        'read_private_posts' => Capability::read_private_posts,
    )

Usage:

    $postType->setCapabilities($myCapabilitiesArray);

#### setSupports()

The setSupports() method accepts a string array of the WordPress features the post type supports. You can also pass in __false__ to disable all features. Default: title, editor.

    $postType->setSupports('title', 'editor', 'thumbnail');

### Taxonomies

The Taxonomy class requires the plural display name of the taxonomy when instantiated. Optionally, the post types to register the taxonomy with(defaults to post) and the text domain.

The constructor sets up the properties, generates the labels, and ties the [register_taxonomy()](http://codex.wordpress.org/Function_Reference/register_taxonomy) function  to the [init](http://codex.wordpress.org/Plugin_API/Action_Reference/init) hook.

The frameworks checks if the taxonomy exists before adding it.

    $taxonomy = new Taxonomy('Custom Tags', $postType->getSlug);

Terms can be added to the taxonomy by using the addTerm() method. It requires the term to be added and can optionally take the term description. This method checks if the term has already been added and only adds it if it has not. It ties the WordPress function [wp_insert_term](http://codex.wordpress.org/Function_Reference/wp_insert_term) to the [init](http://codex.wordpress.org/Plugin_API/Action_Reference/init) hook. This method can be chained.

    $taxonomy->addTerm('Tag One', 'This is the first tag.');

### Pages

You can create new dashboard pages by using the MenuPage, ObjectPage, UtilityPage, SubMenuPage, and OptionsPage classes. All page classes inherit from the Page abstract class.

All page classes require a title and View when instantiated. Text domain can be provided, optionally.

The base constructor sets the parameters then ties the abstract addPage() method to the [admin_menu](http://codex.wordpress.org/Plugin_API/Action_Reference/admin_menu) hook. This addPage() method class the correct WordPress function to add that type of page. The base display() method is used as the display call back.

#### Setters

Setters are available for capability, menu icon, position. A setter for parent slug is available for SubMenuPage. Setter methods can be chained.

##### setCapability()

The setCapability() method accepts a string that specifies the level of permissions a user needs to access the page. Default: manage_options

The included Capabilities class can be used to make sure valid WordPress capabilities are used.

    $page->setCapability(Capability::manage_options);

##### setMenuIcon()

The setMenuIcon() method accepts a URL or name of a [dashicon](http://melchoyce.github.io/dashicons/) as a string. Default: null

    $page->setMenuIcon('http://placehold.it/15x15');

or...

    $page->setMenuIcon('dashicons-admin-tools');

##### setPosition()

The setPosition() method accepts either an integer or numeric string. If you specify a position already taken by another menu icon them might override each other. Default: null

    $page->setPosition(100);

or...

    $page->setPosition('100');

##### setParentSlug()

The setParentSlug() method is only valid for the SubMenuPage class and is required. It sets the SubMenuPage's parent page. It accepts a string value, the easiest way is to use the parent page object's getSlug() method. Default: null

    $subMenuPage->setParentSlug($parentPage->getSlug());

#### Page Types

##### MenuPage

To add a top-level menu page use the MenuPage class. Calls the [add_menu_page()](http://codex.wordpress.org/Function_Reference/add_menu_page) function.

    $menuPage = new MenuPage('My Page', $myView);

##### ObjectPage

ObjectPage adds a top-level page on the Object level (Posts, Media, Links, Pages, Comments, etc.) Calls the [add_object_page()](http://codex.wordpress.org/Function_Reference/add_object_page) function.

    $objectPage = new ObjectPage('My Page', $myView);

##### UtilityPage

UtilityPage adds a top-level page on the Utility level (Appearance, Plugins, Users, Tools, Settings, etc.) Calls the [add_utility_page()](http://codex.wordpress.org/Function_Reference/add_utility_page) function.

    $utilityPage = new UtilityPage('My Page', $myView);

##### OptionsPage

OptionsPage adds a sub-men page under Settings. Class the [add_options_page](http://codex.wordpress.org/Function_Reference/add_options_page) function.

    $optionsPage = new OptionsPage('My Page', $myView);

##### SubMenuPage

SubMenuPage adds a page as a sub-menu item for another page. Calls the [add_submenu_page()](http://codex.wordpress.org/Function_Reference/add_submenu_page) function.

    $subPage = new SubMenuPage('My Sub Page', $myView);
    $subPage->setParentSlug($myPage->getSlug());

### Settings

The Settings part of the framework consists of three classes. Settings, SettingsSection, and SettingsField.

A SettingsField object represents a single settings field on the page. A SettingsSection object represents a section of SettingsField objects grouped together on the page. The Settings object manages the WordPress interactions and what page the settings are displayed on.

The Settings constructor requires the page slug (string) for the page the settings will be displayed on. Text domain (string) can be passed in optionally.

    $settings = new Settings($myPage->getSlug());

#### SettingsFields

Start by creating your fields. The SettingsField constructor requires the field title (string) and view (View). Prefix (string), text domain (string), and additional arguments (array) can be provided but are optional. Prefix is set to 'lwppfw' by default.

Field title will be converted into an ID for the field in the WordPress database by being processed through sanitize_title() and being prepended by the value of prefix.

You can add anything you would like to the fields view but it is recommended to only specify the form field tag and label.

    $field1 = new SettingsField('Field One', $viewView); // ID is lwppfw-field-one.
    $field2 = new SettingsField('Field Two', $viewView); // ID is lwppfw-field-two.

#### SettingsSection

After you have some fields defined you will want to create a section and add your fields to it.

The SettingsSection constructor requires a title (string), view (View), and optionally takes a text domain (string).

The title will be displays as the section header on the settings page automatically, you do not need to include it in the view.

    $section = new SettingsSection('Section One', $sectionView);

#### Adding SettingsField to SettingsSection

A single SettingsField or an array of SettingsField objects can be assigned to the SettingsSection by using the addFields() method. The addFields() method is chainable.

    $section->addFields($field1)->addFields($field2);

or...

    $section->addFields(array($field1, $field2));

#### Adding SettingsSection to Settings

Once your SettingSection objects are defined you can add them to your Settings by using the Settings addSections() method. Like addFields(), this method accepts a single SettingsSection or an array of SettingsSection and is chainable.

    $settings->addSections($section1)->addSection($section2);

or...

    $settings->addSections(array($section1, $section2));

## View

The View class makes it simpler to display output from your plugin.

It allows you to take the code that displays the output and gives it its own file (the view). The view is separated from your logic keeping your code cleaner, easier to read, and easier to manage.

Create a directory in your project to hold all your view files is a good practice.

Use the View class' render() function to display the view and send any data the view needs to know about.

    $view = new View($viewFile, $viewData = null);
    $view->render();

$viewFile should contain the full path and file name of the view file to render.

$viewData is used to pass data to the view if needed. It is an associated array. To use the data in the view file use a variable with the name of the data's key in the array. For example `$viewData['example']` will be `$example` in the view.
