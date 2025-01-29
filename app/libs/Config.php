<?php
/**
 * Project's configuration
 */

class Config {
    // Database configuration
    static public $db_hostname = "localhost";
    static public $db_name     = "pokedex";
    static public $db_user     = "root";
    static public $db_pass     = "";
    static public $charset     = "utf-8";

    // Images
    static public $images_base_path     = "web/images/";
    static public $images_artworks_path = "web/images/artworks/";
    static public $images_sprites_path  = "web/images/sprites/";
    static public $images_gifs_path     = "web/images/gifs/";
    static public $images_trainers_path = "web/images/trainers/";
    static public $images_types_path    = "web/images/types/";

    static public $default_avatar = "web/images/trainers/red.php";

    static public $allowed_image_extensions = ["png"];
    static public $allowed_profile_extensions = ["png", "jpg", "jpeg"];
    static public $allowed_animation_extensions = ["gif"];

    static public $max_file_size = 5000000; // 5MB
}

?>
