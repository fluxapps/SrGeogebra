GeogebraPageComponent = {
    create: function (dom_element_id, plugin_dir, file_name, properties) {
        // Double encoding required
        file_name = encodeURI(file_name);
        properties = GeogebraPageComponent.parseProperties(properties, file_name);
        var ggbApp = new GGBApplet(properties, true);

        //window.addEventListener("load", function () {
            ggbApp.setHTML5Codebase(plugin_dir + "/html/web3d/");
            ggbApp.inject(dom_element_id);
        //});
    },


    parseProperties: function (properties, file_name) {
        var adjustedProperties = {};

        for (var k in properties) {
            if (properties.hasOwnProperty(k)) {
                if (k.startsWith("advanced_")) {
                    var adjustedKey = k.replace("advanced_", "");
                    var value = properties[k];

                    // Border color additionally requires a #
                    if (k.startsWith("advanced_borderColor")) {
                        value = "#" + properties[k];
                    }
                    adjustedProperties[adjustedKey] = value;
                }
            }
        }

        for (var k in properties) {
            if (properties.hasOwnProperty(k)) {
                if (k.startsWith("custom_")) {
                    var adjustedKey = k.replace("custom_", "");
                    adjustedProperties[adjustedKey] = properties[k];
                }
            }
        }

        // Add filename to properties
        adjustedProperties["filename"] = file_name;

        return adjustedProperties;
    }
};