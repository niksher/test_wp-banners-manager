<?php

/*
Plugin Name: koranBanners
Description: managing banners for mobile app
Version: 1.0
*/

/*  Copyright 2017  niksher  (email: niksher18@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

register_activation_hook(__FILE__, 'koran_banners_install');
register_deactivation_hook(__FILE__, 'koran_banners_uninstall');

function koran_banners_install(){
    global $wpdb;
    $table_name = $wpdb->prefix . "koran_banners_plugin";
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE " . $table_name . " (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            type int(1) DEFAULT '0' NOT NULL,
            validFrom varchar(255) NOT NULL COLLATE utf8_general_ci,
            validUntil varchar(255) NOT NULL COLLATE utf8_general_ci,
            title varchar(255) NULL COLLATE utf8_general_ci,
            image varchar(255) NOT NULL COLLATE utf8_general_ci,
            details varchar(255) NOT NULL COLLATE utf8_general_ci,
            detailsTitle varchar(255) NULL COLLATE utf8_general_ci,
            width mediumint(9) NULL,
            height mediumint(9) NULL,
            UNIQUE KEY id (id)
            );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

add_action('admin_menu', 'koran_banners_plugin_menu'); 

// 8 - права доступа не ниже администратора
function koran_banners_plugin_menu() {
    $ADMIN_USER_ROLE = 8;
    add_options_page(
        'Koran Banners Plugin Options'
        , 'Koran Banners Plugin'
        , $ADMIN_USER_ROLE
        , __FILE__
        , 'koran_banners_plugin_options'
    );
}

function koran_banners_plugin_options() {
    global $wpdb;
    
    if (!current_user_can('8')) {
        wp_die( __('У вас нет прав доступа на эту страницу.') );
    }
    
    wp_register_style( 'style.css', plugin_dir_url( __FILE__ ) . 'assets/style.css', array());
    wp_enqueue_style( 'style.css');
    
    wp_register_script( 'script.js', plugin_dir_url( __FILE__ ) . 'assets/script.js', array());
    wp_register_script( 'jquery.min.js', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', array());
    wp_enqueue_script( 'jquery.min.js' );
    wp_enqueue_script( 'script.js' );

    
    if ($_GET["status"] == "add") {
        if (isset($_POST["image"])) {
            $table_name = $wpdb->prefix . "koran_banners_plugin";
           
            $type = (int)$_POST["type"];
            $validFrom = $_POST["validFrom"];
            $validUntil = $_POST["validUntil"];
            $title = $_POST["title"];
            $image = $_POST["image"];
            $details = $_POST["details"];
            $detailsTitle = $_POST["detailsTitle"];
            $width = $_POST["width"];
            $height = $_POST["height"];
            $wpdb->insert($table_name, [
                "type" => $type
                , "validFrom" => $validFrom
                , "validUntil" => $validUntil
                , "title" => $title
                , "image" => $image
                , "details" => $details
                , "detailsTitle" => $detailsTitle
                , "width" => $width
                , "height" => $height
            ]);
        }
        
        $banner = [];
        $formUrl = $_SERVER["REQUEST_URI"];
        
        include __DIR__ . './view/item.php';
    }
    if ($_GET["status"] == "edit") {
        if (isset($_POST["id"])) {
            $table_name = $wpdb->prefix . "koran_banners_plugin";
            
            $id = (int)$_POST["id"];
            $type = (int)$_POST["type"];
            $validFrom = $_POST["validFrom"];
            $validUntil = $_POST["validUntil"];
            $title = $_POST["title"];
            $image = $_POST["image"];
            $details = $_POST["details"];
            $detailsTitle = $_POST["detailsTitle"];
            $width = $_POST["width"];
            $height = $_POST["height"];
            
            $wpdb->update($table_name, [
                "type" => $type
                , "validFrom" => $validFrom
                , "validUntil" => $validUntil
                , "title" => $title
                , "image" => $image
                , "details" => $details
                , "detailsTitle" => $detailsTitle
                , "width" => $width
                , "height" => $height
            ], [
                    "id" => $id
            ]);
        }
        
        $id = strip_tags((int)$_GET["id"]);
        $table_name = $wpdb->prefix . "koran_banners_plugin";
        $banner = $wpdb->get_row("SELECT * FROM $table_name WHERE id=$id");
        $formUrl = $_SERVER["REQUEST_URI"];
        
        require __DIR__ . './view/item.php';
    }
    if ($_GET["status"] == "generate") {
        $table_name = $wpdb->prefix . "koran_banners_plugin";
        $banners = $wpdb->get_results("SELECT * FROM $table_name");
        $out = [];
        foreach ($banners as $banner) {
            if ((int)$banner->type == 0) {
                $out[] = [
                    "type" => (int)$banner->type
                    , "id" => (int)$banner->id
                    , "validFrom" => $banner->validFrom
                    , "validUntil" => $banner->validUntil
                    , "title" => $banner->title
                    , "image" => $banner->image
                    , "details" => $banner->details
                    , "detailsTitle" => $banner->detailsTitle
                ];
            } else {
                $out[] = [
                    "type" => (int)$banner->type
                    , "id" => (int)$banner->id
                    , "validFrom" => $banner->validFrom
                    , "validUntil" => $banner->validUntil
                    , "image" => $banner->image
                    , "details" => $banner->details
                    , "detailsTitle" => $banner->detailsTitle
                    , "size" => [
                        "width" => $banner->width
                        , "height" => $banner->height
                    ]
                ];
            }
            

        }
        $json = [
            "banners" => $out
        ];
        file_put_contents(__DIR__ . "/out.json", json_encode($json));
        $_GET["status"] = NULL;
    }
    if (!$_GET["status"]) {
        
        $table_name = $wpdb->prefix . "koran_banners_plugin";
        $banners = $wpdb->get_results("SELECT * FROM $table_name");
        if (file_exists(__DIR__ . "/out.json")) {
            $json = true;
        }
        include __DIR__ . './view/list.php';
    }
}