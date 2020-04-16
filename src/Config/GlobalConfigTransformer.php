<?php

namespace srag\Plugins\SrGeogebra\Config;

class GlobalConfigTransformer
{
    public function transformProperties(&$a_properties) {
        $immutable_config_values = Repository::getInstance()->getValue(ConfigAdvancedGeogebraFormGUI::KEY_IMMUTABLE);
        $updated_config_values = $this->adjustConfigToPropertySyntax($immutable_config_values);

        foreach ($updated_config_values as $old_designation => $new_designation) {
            $a_properties[$new_designation] = Repository::getInstance()->getValue($old_designation);
        }


    }

    public function adjustConfigToPropertySyntax($immutable_config_values) {
        $adjustedProperties = [];

        foreach ($immutable_config_values as $immutable_config_value) {
            // Replace "default_" with "custom_" on default config fields
            if (strpos($immutable_config_value, "default_") === 0) {
                $new_designation = str_replace("default_", "custom_", $immutable_config_value);
                $adjustedProperties[$immutable_config_value] = $new_designation;
            } else {
                // Prepend "advanced_" to advanced config fields
                $new_designation = "advanced_" . $immutable_config_value;
                $adjustedProperties[$immutable_config_value] = $new_designation;
            }
        }

        return $adjustedProperties;
    }
}