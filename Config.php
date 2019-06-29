<?php
/**
 * Config class script
 * Sets hosting service variables
 *
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

class Config
{
    public static function Languages()
    {
        $languages = array();

        array_push($languages, new Language("fa", "فارسی", "ir", "r", "🇮🇷"));
        array_push($languages, new Language("en", "English", "us", "l", "🇺🇸"));
        // array_push($languages, new Language("ku", "کوردی", "iq", "r", "🇮🇶"));
        // array_push($languages, new Language("ar", "العربية", "ae", "r", "🇦🇪"));
        
        return $languages;
    }

    const TimeZone = "Asia/Tehran";
    const DefaultLanguage = "en-us";

    const ConnectionString_SERVER  = "localhost";
    const ConnectionString_DATABASE = "SnowKMS";
    const ConnectionString_USERNAME  = "root";
    const ConnectionString_PASSWORD = "123";

    // TODO: Multi Domain Support
    const BASEURL = "http://localhost/SnowFramework/"; //       /Anything
    const TITLE = "سامانه‌ی مدیریت دانش";
    const LANGUAGE = "English";
    const REGION = "IR";
    const NAME = "مدیر دانش";
    const SPONSOR = "Gordarg";
    const META_KEYWORDS = "knowledge, social network, content, SEO, telecommunications, e-business";
    const META_DESCRIPTION = "DESCRIPTION HERE";
    const META_AUTHOR = "";
    
    const WebMaster = "info@gordarg.com";

    const mail_hostname = "{mail.gordarg.com:110/pop3/notls}Inbox";
    const mail_username = "info@gordarg.com";
    const mail_password = '';
}