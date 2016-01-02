## 5.0.3

* Add more options to the radio button MetaBox helper

### 5.0.2

* Added `es` option to Helper::makeSingular()

### 5.0.1

* Added `delete_posts` capability to PostType class

### 5.0.0

* Due to the nature of this update most object constructor signatures have been changed and will need to be updated
* Slugs are no longer generated automatically but required on object instantiation
* Meta boxes have been completely reworked
    * Now supports multiple fields per meta box
    * Fixed saving for checkboxes
    * Fields are created for the meta box by using static methods in the meta box's view file
* Moved isValid() method to Capability class
* Removed Enum class

### 4.0.0

* Due to the nature of this update most object constructor signatures have been changed and will need to be updated
* View class made static
* $viewFile property added to WordPressObject class
* $viewData property added to WordPressObject class
* display() method added to WordPressObject class
* $prefix is now required on SettingsField class
* Default $prefix value removed for SettingsField class
* $args property removed from SettingsField class, use $viewData instead
* Redundant properties and methods removed from child classes
* Created Helper static class
* Moved makeSingular() from WordPressObject to Helper
* Misc. refactoring

### 3.0.0

* Initial public release as SPF
