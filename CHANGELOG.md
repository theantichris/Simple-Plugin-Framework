### 4.0.0

* Due to the nature of this update most object constructor signatures have been updated
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

### 3.0.0

* Initial public release as SPF
