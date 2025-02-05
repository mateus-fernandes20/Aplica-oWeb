<?php
class ApiHelper
{
    public static function getApiToken() {
        $file = Yii::getPathOfAlias('application') . '/config/secret.txt';
        if (file_exists($file)) {
            return trim(file_get_contents($file));
        }
        return null; // Return null if file doesn't exist or is empty
    }
}
?>