GeogebraPageComponent = {
    create: function (dom_element_id, plugin_dir, file_name, properties) {
        console.log(properties);
        var ggbApp = new GGBApplet({
            "appName": "geometry",
            "filename": file_name,
            "width": 800,
            "height": 600,
            "showToolBar": true,
            "showMenuBar": true
        }, true);

        window.addEventListener("load", function () {
            ggbApp.setHTML5Codebase(plugin_dir + "/html/web3d/");
            ggbApp.inject(dom_element_id);
        });
    }
};