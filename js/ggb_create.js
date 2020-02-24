GeogebraPageComponent = {
    create: function (dom_element_id, plugin_dir, file_name) {
        var ggbApp = new GGBApplet({
            "appName": "graphing",
            "filename": file_name,
            "width": 800,
            "height": 600,
            "showToolBar": true,
            "showAlgebraInput": true,
            "showMenuBar": true
        }, true);

        window.addEventListener("load", function () {
            ggbApp.setHTML5Codebase(plugin_dir + "/html/web3d/");
            ggbApp.inject(dom_element_id);
        });
    }
};