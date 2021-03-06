# SPF: Simple Plugin Framework

## Introduction

This is a simple framework for developing WordPress plugins.

Entities in WordPress (post types, taxonomies, etc.) are treated as objects so creating a new entity and setting it's
properties are the same as any object in PHP. Each object handles tying itself to the appropriate WordPress action hook
when it is instantiated.

## Getting Started

### Composer

The package is hosted on [Packagist](https://packagist.org/packages/theantichris/simple-plugin-framework) and ready to be
using with [Composer](https://getcomposer.org/). Just add package to your composer.json.

### Using SPF in Your Plugin

The easiest way to start using SPF is to create a class for your plugin and place the framework code in the classes
constructor.


    class myPlugin
    {
        public function __construct()
        {
            // Place SPF code in there.
        }
    }

    new myPlugin();

## Creating WordPress Objects

SPF contains classes for creating post types, taxonomies, pages, settings, and Dashboard widgets. These classes all
inherit from the WordPressObject class.

### WordPressObject

The WordPressObject class provides some common methods the other classes use and a static property for defining your
text domain. This is an abstract class and cannot be instantiated.

#### Text Domain

To specify a custom text domain for all the WordPressObject classes set the static property $textDomain on the
WordPressObject parent class. This is optional, the text domain has a default value of 'default'.

    WordPressObject::$textDomain = 'my-text-domain';

#### getSlug()

This public method returns the object's slug. A slug is a unique identifier for the object in the WordPress database.
This method is used within the framework to tie related objects together.

    echo $someObject->getSlug();

#### getName()

Use this public method to get the object's user-readable display name. The $name property is passed through the text
domain before it is returned.

    echo $someObject->getName();

#### display()

This method is never called directly but used as the display callback function for the WordPress Objects. It calls the
View class' render() method passing in the object's $viewFile and $viewData property.

### PostType

The PostType class constructor requires the name of the post type and a slug to be created. The name must be plural for
the labels to be generated correctly.

The PostType class constructor generates the labels for the post type and then ties the
[register_post_type()](http://codex.wordpress.org/Function_Reference/register_post_type) function to the
[init](http://codex.wordpress.org/Plugin_API/Action_Reference/init) hook.

    $postType = new PostType('My Post Type');

The rest of the properties for PostType have defaults set to create a basic, publicly facing post type but can be
overridden using setters.

#### setDescription()

The setDescription() method accepts a string.

    $postType->setDescription('This is my custom post type.');
    
#### hasArchive()

The hasArchive() method accepts a boolean value. The default is true.

    $postType->hasArchive(false);

#### setPublic()

The setPublic() method accepts a bool. This determines if the post type shows in the Dashboard and front end of the
site.

    $postType->setPublic(false);

#### setMenuPosition()

The setMenuPosition() method accepts an integer or numeric string. The higher the number, the higher the post type's
menu item is in the Dashboard. If you specify a value taken by another menu item one might override the other.

    $postType->setMenuPosition(85);

or...

    $postType->setMenuPosition('85');

#### setMenuIcon()

The setMenuIcon() method accepts an image URL or [dashicon](http://melchoyce.github.io/dashicons/) as a string.

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

The setSupports() method accepts a string array of the WordPress features the post type supports. You can also pass in
__false__ to disable all features.

    $postType->setSupports(['title', 'editor', 'thumbnail']``);

### Taxonomies

The Taxonomy class requires the plural display name of the taxonomy and a slug when instantiated. Optionally, the post
types to register the taxonomy with (defaults to post) and the text domain.

The constructor sets up the properties, generates the labels, and ties the
[register_taxonomy()](http://codex.wordpress.org/Function_Reference/register_taxonomy) function  to the
[init](http://codex.wordpress.org/Plugin_API/Action_Reference/init) hook.

SPF checks if the taxonomy exists before adding it.

    $taxonomy = new Taxonomy('Custom Tags', $postType->getSlug);

Terms can be added to the taxonomy by using the addTerm() method. It requires the term to be added and can optionally
take the term description. This method checks if the term has already been added and only adds it if it has not. It ties the WordPress function [wp_insert_term](http://codex.wordpress.org/Function_Reference/wp_insert_term) to the [init](http://codex.wordpress.org/Plugin_API/Action_Reference/init) hook. This method can be chained.

    $taxonomy->addTerm('Tag One', 'This is the first tag.');

### MetaBoxes

Meta boxes containing 1 or more custom field can be added to your post types using this class. The object requires the
name, post type slugs to attach it to, and a view file when instantiated. View data can be passed in optionally.

The constructor sets the properties then ties the addMetaBox() method to the
[add_meta_boxes](http://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes) hook and the saveMetaBox()
method to the [save_post](http://codex.wordpress.org/Plugin_API/Action_Reference/save_post) hook.

The $postTypes argument can either be a single string or an array of strings if you want to tie the meta box to multiple
 post types.

    $metaBox = new MetaBox('My MetaBox', $postTypes, $viewFiles, $viewData);

The class automatically handles saving the custom fields to the WordPress database when the post is updated.

#### Setters

Setters are available for the context and priority properties.

##### setContext()

This sets the part of the page the meta box will be shown on. Accepted values are 'normal', 'advanced', and 'side'. The
default is 'advanced'.

    $metaBox->setContext('side');

##### setPriority()

This sets the priority within the context where the box will be shown. Accepted values are 'high', 'core', 'default' and
 'low'. The default is 'default'.

    $metaBox->setPriority('low');

#### Custom Fields

To add custom fields to the meta box using the MetaBox class' static methods in the meta box's view file.

    MetaBox::CheckboxInput($name, $slug, $value, $default = '');
    MetaBox::ColorInput($name, $slug);
    MetaBox::DateInput($name, $slug);
    MetaBox::DateTimeInput($name, $slug);
    MetaBox::DateTimeLocalInput($name, $slug);
    MetaBox::EmailInput($name, $slug);
    MetaBox::FileInput($name, $slug);
    MetaBox::HiddenInput($name, $slug);
    MetaBox::MonthInput($name, $slug);
    MetaBox::NumberInput($name, $slug, $step = '1');
    MetaBox::PasswordInput($name, $slug);
    MetaBox::RadioButtonInputs($name, $slug, $options, $displayBlock);
    MetaBox::RangeInput($name, $slug, $min, $max);
    MetaBox::SearchInput($name, $slug);
    MetaBox::SelectInput($name, $slug, $options);
    MetaBox::TelInput($name, $slug);
    MetaBox::Textarea($name, $slug, $rows, $cols);
    MetaBox::TextInput($name, $slug);
    MetaBox::TimeInput($name, $slug);
    MetaBox::UrlInput($name, $slug);
    MetaBox::WeekInput($name, $slug);

### Pages

You can create new dashboard pages by using the MenuPage, ObjectPage, UtilityPage, SubMenuPage, and OptionsPage classes.
 All page classes inherit from the Page abstract class.

All page classes require a name, slug, and view file when instantiated, $viewData can be passed in optionally.  The slug
 and name are added to the $viewData array automatically.

The base constructor sets the parameters then ties the abstract addPage() method to the
[admin_menu](http://codex.wordpress.org/Plugin_API/Action_Reference/admin_menu) hook. This addPage() method is
overridden in the child classes to use the correct WordPress function to add that type of page.

#### Setters

Setters are available for capability, menu icon, position. A setter for parent slug is available for SubMenuPage.

##### setCapability()

The setCapability() method accepts a string that specifies the level of permissions a user needs to access the page.

The included Capabilities class can be used to make sure valid WordPress capabilities are used.

    $page->setCapability(Capability::manage_options);

##### setMenuIcon()

The setMenuIcon() method accepts a URL or name of a [dashicon](http://melchoyce.github.io/dashicons/) as a string.

    $page->setMenuIcon('http://placehold.it/15x15');

or...

    $page->setMenuIcon('dashicons-admin-tools');

##### setPosition()

The setPosition() method accepts either an integer or numeric string. If you specify a position already taken by another
 menu icon them might override each other.

    $page->setPosition(100);

or...

    $page->setPosition('100');

##### setParentSlug()

The setParentSlug() method is only available to the SubMenuPage class. Setting the parent slug is required. It sets the
SubMenuPage's parent page. It accepts a string value, the easiest way is to use the parent page object's getSlug()
method. Set $parentSlug to null to create a page that does not appear in the menu.

    $subMenuPage->setParentSlug($parentPage->getSlug());

#### Page Types

##### MenuPage

To add a top-level menu page use the MenuPage class. Calls the
[add_menu_page()](http://codex.wordpress.org/Function_Reference/add_menu_page) function.

    $menuPage = new MenuPage('My Page', $myView);

##### ObjectPage

ObjectPage adds a top-level page on the Object level (Posts, Media, Links, Pages, Comments, etc.) Calls the
[add_object_page()](http://codex.wordpress.org/Function_Reference/add_object_page) function.

    $objectPage = new ObjectPage('My Page', $myView);

##### UtilityPage

UtilityPage adds a top-level page on the Utility level (Appearance, Plugins, Users, Tools, Settings, etc.) Calls the
[add_utility_page()](http://codex.wordpress.org/Function_Reference/add_utility_page) function.

    $utilityPage = new UtilityPage('My Page', $myView);

##### OptionsPage

OptionsPage adds a sub-men page under Settings. Class the
[add_options_page](http://codex.wordpress.org/Function_Reference/add_options_page) function.

    $optionsPage = new OptionsPage('My Page', $myView);

##### SubMenuPage

SubMenuPage adds a page as a sub-menu item for another page. Calls the
[add_submenu_page()](http://codex.wordpress.org/Function_Reference/add_submenu_page) function.

    $subPage = new SubMenuPage('My Sub Page', $myView);
    $subPage->setParentSlug($myPage->getSlug());

### Settings

The Settings API part of SPF consists of three classes. Settings, SettingsSection, and SettingsField.

A SettingsField object represents a single settings field and a SettingsSection object represents a section of
SettingsField objects.

The Settings object manages the WordPress interactions and what page the settings will be displayed displayed on.

The Settings constructor requires the slug for the page the settings will be displayed on.

    $settings = new Settings($myPage->getSlug());

#### SettingsFields

The SettingsField constructor requires a name, slug, and a view file to be passed in. View data can be passed in as
well.

You must specify a prefix for your field's slugs to help prevent naming conflicts in the database by using the $prefix
parameter.

The view file should only contain the HTML and logic needed to render the input field. The name and slug are added to
the $viewData property automatically.

    $field = new SettingsField('My Field', $prefix, $viewView, $viewData);

#### SettingsSection

The SettingsSection class requires a name and slug to be instantiated. A view file and view data can be passed in,
optionally.

Unless you need to display something specific like instructions to the user you do not need to include a view file since
WordPress will automatically display the section's name on the page.

If you do use a view file the name is added to the $viewData property automatically.

    $section = new SettingsSection('Section One', $viewFile, $viewData);

#### Adding SettingsField to SettingsSection

A single SettingsField or an array of SettingsField objects can be assigned to the SettingsSection by using the
addFields() method.

    $section->addFields($field1)->addFields($field2);

or...

    $section->addFields(array($field1, $field2));

#### Adding SettingsSection to Settings

SettingSection objects are added Settings objects by using the Settings' addSections() method. Like addFields(), this
method accepts a single SettingsSection or an array of SettingsSection.

    $settings->addSections($section1)->addSection($section2);

or...

    $settings->addSections(array($section1, $section2));

### DashboardWidget

You can use the DashboardWidget class to add a new widget to the WordPress dashboard.

The class takes a name, slug, and path to a view file when instantiated. Data you need to pass to the view can be supplied in
the optional $viewData argument. The DashboardWidget's name and slug are automatically added to the $viewData.

The constructor assigns the properties and ties the addWidget() method to the
[wp_dashboard_setup](http://codex.wordpress.org/Plugin_API/Action_Reference/wp_dashboard_setup) hook.

The addWidget() method calls the WordPress function
[wp_add_dashboard_widget](http://codex.wordpress.org/Function_Reference/wp_add_dashboard_widget).

    $myWidget = new DashboardWidget('My Widget', $widgetView);

### WelcomePanel

You can replace the default WordPress welcome panel with a custom welcome panel using this class. This is accomplished
using the [welcome_panel](http://codex.wordpress.org/Plugin_API/Action_Reference/welcome_panel) hook.

The class only requires a view file to be passed in but view data can be passed in optionally. The view file will
contain the HTML you would like to the welcome panel to display.

    $welcomePanel = new WelcomePanel($welcomePanelView);

## Views

The WordPressObject classes use the included static View class to display their output. Each object has a display()
method that is used as the callback in the WordPress functions.

This display() method calls View::render() passing in the $viewFile and $viewData properties. The $viewFile property is
a string representing the full path and file name of the file to use as the view. The $viewData property is an
associative array of extra information needed in the view file if any.

The render() method [extracts](http://php.net/manual/en/function.extract.php) the $viewData property to make variables
in the view. For example `$viewData['foo']` becomes `$foo`.

A view file is, at minimum, a php file that contains the HTML output of the object. You can include as little or as much
logic in your view file as you want.
