## SrGeogebra-Documentation

### Overview

SrGeogebra is an ILIAS Plugin used to display GeoGebra (.ggb) files inside the ILIAS page editor. The ILIAS page editor is the editor used in Wikis, ILIAS learning modules or if you "Customize Pages" of courses or groups.

https://www.geogebra.org/

> This documentation will teach you how to use the SrGeoGebra plugin within ILIAS learning modules.

### Usage

* Create SrGeoGebra objects
* Upload .ggb files
* Display .ggb files
* Edit SrGeoGebra objects
* Delete SrGeoGebra objects
* Set default values of new SrGeoGebra objects

### Setting up

To use this plugin it is required to add the file extension "ggb" into the ILIAS file upload whitelist.

Select the "Administration" tab and choose the entry "Files".

![Setup Administration](images/setup_administration.png)

1. Switch to the tab "Upload Settings".
2. Enter the value "ggb" inside the "Custom Suffix Whitelist" text area.
3. Click "Save".

> Some values may already be inside the "Custom Suffix Whitelist" text area. In that case, separate each value with a comma. (E.g. "xyz, ggb")

![Setup Add ggb](images/setup_add.png)

#### Create SrGeoGebra objects

A user is able to create a new SrGeoGebra object by clicking the button "Click here to add content" and selecting the menu entry "Insert GeoGebra Object".

![Create SrGeoGebra](images/create_geogebra.png)

The user must now fill out all the form inputs correctly to successfully create a new SrGeoGebra object. The following inputs are presented to the user:

* __Title:__ The title this object should have. (Not displayed anywhere)
* __Upload:__ The .ggb file this object should display.
* __Width:__ The width this object should have. (In Pixels, e.g. 800)
* __Height:__ The height this object should have. (In Pixels, e.g. 600)
* __Enable Dragging And Zooming:__ States whether the Graphics View(s) should be moveable using Shift + mouse drag (or. Ctrl + mouse drag) or zoomable using Shift + mouse wheel (or Ctrl + mouse wheel). Setting this parameter to "false" disables moving and zooming of the drawing pad.
* __Enable Reset Icon:__ States whether a small icon (GeoGebra ellipse) should be shown in the upper right corner of the applet. Clicking on this icon resets the applet (i.e. it reloads the file given in the filename parameter).
* __Alignment:__ The side this object should be aligned to.

> Hint: The settings above are all considered "generic" settings. To keep creation simple, all "advanced" options are automatically taken from the plugin configuration. 

Finally, the user must click the button "Create" to save all inputs. The object has now been created.

![Create SrGeoGebra Form](images/create_geogebra_form.png)

#### Edit generic settings of SrGeoGebra objects

A user is able to edit the generic settings of a SrGeoGebra object by clicking onto an existing SrGeoGebra object and selecting the menu entry "Edit".

![Edit SrGeoGebra](images/edit_geogebra.png)

The user is now able to edit the generic settings by changing the values of the inputs as desired and clicking the button "Save". The object has now been edited.

![Edit SrGeoGebra Form](images/edit_geogebra_form.png)

#### Edit advanced settings of SrGeoGebra objects

A user is able to edit the advanced settings of a SrGeoGebra object by clicking onto an existing SrGeoGebra object and selecting the menu entry "Edit".

![Edit SrGeoGebra](images/edit_geogebra.png)

The user must now select "Advanced Settings" at the top.

![Edit SrGeoGebra Advanced Settings](images/advanced_settings_path.png)

The user is now able to edit the advanced settings by changing the values of the inputs as desired and clicking the button "Save". The object has now been edited. The user may now use the "< Page" button to return back to the edit page.

![Edit SrGeoGebra Advanced Settings Form](images/advanced_settings_form.png)

#### Delete SrGeoGebra objects

A user is able to delete a SrGeoGebra object by clicking onto an existing SrGeoGebra object and selecting the menu entry "Delete".

![Delete SrGeoGebra](images/delete_geogebra.png)

The user must accept the prompt by selecting "OK". The object has now been deleted.

#### Edit default settings

##### Note

Default settings are values that are automatically used in place of undefined values. The 5 top inputs starting with "Default" within the configuration are generic settings while all the other inputs are advanced settings. When creating a new SrGeoGebra object, the top 5 inputs are merely used as a template for new objects and can be edited. As all the other inputs are advanced settings that can't be defined when creating a new SrGeoGebra object, the values defined in here will automatically transfer onto newly created objects.

> All advanced settings used in this plugin are listed here: https://wiki.geogebra.org/en/Reference:GeoGebra_App_Parameters

##### Usage

An administrator is able to edit the default settings by accessing the plugin configuration under __Administration -> Plugins -> Actions/Configure__.

![Configure SrGeoGebra](images/configure_path.png)

The administrator is now able to edit the default settings by changing the values of the inputs as desired and clicking the button "Save". The default settings have now been set.

![Configure SrGeoGebra Form](images/configure_form.png)

#### Immutable fields

##### Note

> This feature requires at least version 0.5.1 of the SrGeoGebra plugin

Immutable fields are fields that cannot be changed within SrGeoGebra objects and always use the value from the plugin configuration instead.

##### Usage

An administrator is able to manage immutable fields by accessing the plugin configuration under __Administration -> Plugins -> Actions/Configure__.

![Configure SrGeoGebra](images/configure_path.png)

The administrator is now able to manage immutable fields by clicking into the "Immutable Fields" field. A context menu with all possible configuration settings will pop up. Select the fields that you wish to make unchangeable.

![Configure SrGeoGebra](images/immutable_add_entries.png)

Entires may be removed by selecting the "x" next to each name.

![Configure SrGeoGebra](images/immutable_added_entries.png)

Click the button "Save" if you are finished. The immutable fields have now been set.

#### Result

Every existing GeoGebra object will be forced to use the unchangeable values within the configuration. Maintainers of SrGeoGebra objects are not able to change these values by editing their SrGeoGebra objects. However, they are able to detect unchangeable values as they remain greyed out.

![Configure SrGeoGebra](images/immutable_greyed.png)

> Please note that the values of exisiting objects are not replaced upon changing a field to immutable. However, these objects prioritize the value from the configuration. (E.g. a SrGeoGebra object has a width of 400. The width then gets changed to an immutable field with the value 1000. The user then reverts the width back to a changeable field, keeping the value 400 from earlier.)

### Hints

* Scaled objects are always forced to be aligned to the left
* Only downscaling is currently supported
