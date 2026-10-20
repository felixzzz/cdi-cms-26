<?php

namespace App\Enums;

enum PreferenceKey: string
{
    // HOME PAGE
    case home_banner = 'home_banner';
    case home_banner_tagline = 'home_banner_tagline';
    case home_about_section = 'home_about_section';

    case home_infrastructure_title = 'home_infrastructure_title';
    case home_infrastructure_energy = "home_infrastructure_energy";
    case home_infrastructure_water = "home_infrastructure_water";
    case home_infrastructure_port_storage = "home_infrastructure_port_storage";
    case home_infrastructure_logistic = "home_infrastructure_logistic";

    case home_discover_title = "home_discover_title";
    case home_discover_sustainability = "home_discover_sustainability";
    case home_discover_our_business = "home_discover_our_business";
    case home_discover_investor = "home_discover_investor";
    case home_discover_career = "home_discover_career";

    case home_journey_tagline = "home_journey_tagline";
    case home_journey_content = "home_journey_content";
    case home_journey_info_1 = "home_journey_info_1";
    case home_journey_info_2 = "home_journey_info_2";
    case home_journey_info_3 = "home_journey_info_3";

    case about_us_banner = 'about_us_banner';
    case about_us_company_overview_tagline = 'about_us_company_overview_tagline';
    case about_us_company_overview = 'about_us_company_overview';
    case about_us_company_overview_background = 'about_us_company_overview_background';
    case about_us_vision_mission_tagline = 'about_us_vision_mission_tagline';
    case about_us_vision = 'about_us_vision';
    case about_us_mission = 'about_us_mission';
    case about_us_milestone = 'about_us_milestone';
    case about_us_company_profile = 'about_us_company_profile';
    case about_us_youtube = 'about_us_youtube';

    case about_us_management_banner = 'about_us_management_banner';
    case about_us_management_overview = 'about_us_management_overview';
    case about_us_organization_structure = 'about_us_organization_structure';
    case about_us_corporate_structure = 'about_us_corporate_structure';
    case about_us_corporate_structure_en = 'about_us_corporate_structure_en';
    case about_us_corporate_structure_id = 'about_us_corporate_structure_id';
    case about_us_corporate_structure_table = 'about_us_corporate_structure_table';
    case about_us_guideline = 'about_us_guideline';
    case about_us_corporate_structure_table_show = 'about_us_corporate_structure_table_show';

    case about_us_award_banner = 'about_us_award_banner';
    case about_us_award_overview = 'about_us_award_overview';

    case investor_report_banner = 'investor_report_banner';
    case investor_report_overview = 'investor_report_overview';
    case investor_report_table = 'investor_report_table';
    case investor_financial_banner = 'investor_financial_banner';
    case investor_share_banner = 'investor_share_banner';
    case investor_share_shareholders_table = 'investor_share_shareholders_table';
    case investor_share_dividend_table = 'investor_share_dividend_table';
    case investor_share_bonds_table = 'investor_share_bonds_table';
    case investor_publication_banner = 'investor_publication_banner';
    case investor_share_tab_one = 'investor_share_tab_one';
    case investor_share_tab_two = 'investor_share_tab_two';

    case investor_share_shareholders_table_show = 'investor_share_shareholders_table_show';
    case investor_share_dividend_table_show = 'investor_share_dividend_table_show';
    case investor_share_bonds_table_show = 'investor_share_bonds_table_show';
    case investor_report_table_show = 'investor_report_table_show';

    case governance_banner = 'governance_banner';
    case governance_corporate_secretary_team = 'governance_corporate_secretary_team';
    case governance_corporate_secretary = 'governance_corporate_secretary';
    case governance_internal_audit_unit = 'governance_internal_audit_unit';
    case governance_audit_committe = 'governance_audit_committe';
    case governance_audit_committe_member_text = 'governance_audit_committe_member_text';
    case governance_sustainability_committe = 'governance_sustainability_committe';
    case governance_risk_management = 'governance_risk_management';
    case governance_code_of_conduct = 'governance_code_of_conduct';
    case governance_she_regulation = 'governance_she_regulation';
    case governance_policy = 'governance_policy';
    case governance_whistleblowing = 'governance_whistleblowing';
    case governance_whistleblowing_id = 'governance_whistleblowing_id';
    case governance_whistleblowing_detail = 'governance_whistleblowing_detail';

    case governance_audit_committe_show = 'governance_audit_committe_show';
    case governance_audit_committe_member_text_show = 'governance_audit_committe_member_text_show';
    case governance_sustainability_committe_show = 'governance_sustainability_committe_show';
    case governance_risk_management_show = 'governance_risk_management_show';
    case governance_she_regulation_show = 'governance_she_regulation_show';
    case governance_policy_show = 'governance_policy_show';

    case our_business_banner = 'our_business_banner';
    case our_business_overview = 'our_business_overview';

    case sustainability_overview_banner = 'sustainability_overview_banner';
    case sustainability_overview_content = 'sustainability_overview_content';
    case sustainability_overview_policy_framework = 'sustainability_overview_policy_framework';
    case sustainability_overview_policy_framework_show = 'sustainability_overview_policy_framework_show';
    case sustainability_overview_policy_framework_file = 'sustainability_overview_policy_framework_file';
    case sustainability_overview_rating = 'sustainability_overview_rating';
    case sustainability_overview_rating_show = 'sustainability_overview_rating_show';
    case sustainability_environment_banner = 'sustainability_environment_banner';
    case sustainability_environment_overview = 'sustainability_environment_overview';
    case sustainability_social_banner = 'sustainability_social_banner';
    case sustainability_social_overview = 'sustainability_social_overview';
    case sustainability_governance_banner = 'sustainability_governance_banner';
    case sustainability_governance_overview = 'sustainability_governance_overview';
    case sustainability_report_banner = 'sustainability_report_banner';
    case sustainability_action_banner = 'sustainability_action_banner';

    case contact_us_main = 'contact_us_main';
    case media_main = 'media_main';
    case terms_and_conditions = 'terms_and_conditions';
    case privacy_policy = 'privacy_policy';
    case cookies_consent = 'cookies_consent';
    case disclaimer = 'disclaimer';
    case social_youtube = 'social_youtube';
    case social_linkedin = 'social_linkedin';
    case social_tiktok = 'social_tiktok';
    case social_x = 'social_x';
    case social_instagram = 'social_instagram';
    case social_facebook = 'social_facebook';

    case media_blog_status = 'media_blog_status';
    case email_pic_whistleblowing = 'email_pic_whistleblowing';

    case json_ld_homepage = 'json_ld_homepage';
    case json_ld_about_us = 'json_ld_about_us';
    case json_ld_governance = 'json_ld_governance';
    case json_ld_sustainability = 'json_ld_sustainability';
    case json_ld_contact_us = 'json_ld_contact_us';
    case json_ld_our_business = 'json_ld_our_business';
    case llms_txt = 'llms_txt';
    case llms_full_txt = 'llms_full_txt';

    // SEO Meta Keys
    case meta_home = 'meta_home';
    case meta_about_us = 'meta_about_us';
    case meta_about_us_management = 'meta_about_us_management';
    case meta_about_us_awards = 'meta_about_us_awards';
    case meta_our_business = 'meta_our_business';
    case meta_our_business_energy = 'meta_our_business_energy';
    case meta_our_business_water = 'meta_our_business_water';
    case meta_our_business_ports = 'meta_our_business_ports';
    case meta_our_business_logistics = 'meta_our_business_logistics';
    case meta_governance = 'meta_governance';
    case meta_governance_policy = 'meta_governance_policy';
    case meta_governance_whistleblowing = 'meta_governance_whistleblowing';
    case meta_sustainability = 'meta_sustainability';
    case meta_sustainability_environment = 'meta_sustainability_environment';
    case meta_sustainability_social = 'meta_sustainability_social';
    case meta_sustainability_governance = 'meta_sustainability_governance';
    case meta_investor_report = 'meta_investor_report';
    case meta_investor_financial = 'meta_investor_financial';
    case meta_investor_shares = 'meta_investor_shares';
    case meta_investor_publications = 'meta_investor_publications';
    case meta_contact_us = 'meta_contact_us';
    case meta_media_news = 'meta_media_news';
    case meta_terms = 'meta_terms';
    case meta_privacy = 'meta_privacy';
    case meta_cookies = 'meta_cookies';
    case meta_disclaimer = 'meta_disclaimer';

    public function type()
    {
        return match ($this->value) {
            'home_banner' => PreferenceType::TextContentVideo,
            'home_banner_tagline' => PreferenceType::TextContent,
            'home_about_section' => PreferenceType::TextContentImage,
            'home_infrastructure_title' => PreferenceType::Text,
            'home_infrastructure_energy' => PreferenceType::TextContentImage,
            'home_infrastructure_water' => PreferenceType::TextContentImage,
            'home_infrastructure_port_storage' => PreferenceType::TextContentImage,
            'home_infrastructure_logistic' => PreferenceType::TextContentImage,
            'home_discover_title' => PreferenceType::Text,
            'home_discover_sustainability' => PreferenceType::TextContentImage,
            'home_discover_our_business' => PreferenceType::TextContentImage,
            'home_discover_investor' => PreferenceType::TextContentImage,
            'home_discover_career' => PreferenceType::TextContentImage,
            'home_journey_tagline' => PreferenceType::Text,
            'home_journey_content' => PreferenceType::TextContentImage,
            'home_journey_info_1' => PreferenceType::TextContent,
            'home_journey_info_2' => PreferenceType::TextContent,
            'home_journey_info_3' => PreferenceType::TextContent,

            'about_us_banner' => PreferenceType::TextContentImage,
            'about_us_company_overview_tagline' => PreferenceType::TextImage,
            'about_us_company_overview' => PreferenceType::TextContentImage,
            'about_us_company_overview_background' => PreferenceType::Image,
            'about_us_vision_mission_tagline' => PreferenceType::Text,
            'about_us_vision' => PreferenceType::TextContent,
            'about_us_mission' => PreferenceType::TextContent,
            'about_us_milestone' => PreferenceType::TextContentImage,
            'about_us_company_profile' => PreferenceType::TextContent,
            'about_us_youtube' => PreferenceType::TextContent,
            'about_us_management_banner' => PreferenceType::TextContent,
            'about_us_management_overview' => PreferenceType::TextContent,
            'about_us_organization_structure' => PreferenceType::Image,
            'about_us_corporate_structure' => PreferenceType::Image,
            'about_us_corporate_structure_en' => PreferenceType::Image,
            'about_us_corporate_structure_id' => PreferenceType::Image,
            'about_us_corporate_structure_table' => PreferenceType::Table,
            'about_us_guideline' => PreferenceType::TextContent,
            'about_us_award_banner' => PreferenceType::TextContentImage,
            'about_us_award_overview' => PreferenceType::TextContent,
            'about_us_corporate_structure_table_show' => PreferenceType::TextContent,

            'investor_report_banner' => PreferenceType::TextContentImage,
            'investor_report_overview' => PreferenceType::TextContentImage,
            'investor_report_table' => PreferenceType::Table,
            'investor_financial_banner' => PreferenceType::TextContentImage,
            'investor_share_banner' => PreferenceType::TextContentImage,
            'investor_share_shareholders_table' => PreferenceType::Table,
            'investor_share_dividend_table' => PreferenceType::Table,
            'investor_share_bonds_table' => PreferenceType::Table,
            'investor_publication_banner' => PreferenceType::TextContentImage,
            'investor_share_tab_one' => PreferenceType::Text,
            'investor_share_tab_two' => PreferenceType::Text,
            'investor_share_shareholders_table_show' => PreferenceType::TextContent,
            'investor_share_dividend_table_show' => PreferenceType::TextContent,
            'investor_share_bonds_table_show' => PreferenceType::TextContent,
            'investor_report_table_show' => PreferenceType::TextContent,

            'governance_banner' => PreferenceType::TextContentImage,
            'governance_corporate_secretary_team' => PreferenceType::TextContentImage,
            'governance_corporate_secretary' => PreferenceType::TextContent,
            'governance_internal_audit_unit' => PreferenceType::TextContentImage,
            'governance_audit_committe' => PreferenceType::TextContent,
            'governance_audit_committe_member_text' => PreferenceType::TextContent,
            'governance_sustainability_committe' => PreferenceType::Image,
            'governance_risk_management' => PreferenceType::TextContentImage,
            'governance_code_of_conduct' => PreferenceType::TextContent,
            'governance_she_regulation' => PreferenceType::TextContent,
            'governance_policy' => PreferenceType::TextContent,
            'governance_whistleblowing' => PreferenceType::TextContentImage,
            'governance_whistleblowing_id' => PreferenceType::TextContentImage,
            'governance_whistleblowing_detail' => PreferenceType::TextImage,
            'governance_audit_committe_show' => PreferenceType::TextContent,
            'governance_audit_committe_member_text_show' => PreferenceType::TextContent,
            'governance_sustainability_committe_show' => PreferenceType::TextContent,
            'governance_risk_management_show' => PreferenceType::TextContent,
            'governance_she_regulation_show' => PreferenceType::TextContent,
            'governance_policy_show' => PreferenceType::TextContent,

            'our_business_banner' => PreferenceType::TextContentImage,
            'our_business_overview' => PreferenceType::TextContent,

            'sustainability_overview_banner' => PreferenceType::TextContentImage,
            'sustainability_overview_content' => PreferenceType::TextContent,
            'sustainability_overview_rating' => PreferenceType::TextContent,
            'sustainability_overview_policy_framework' => PreferenceType::TextContent,
            'sustainability_overview_policy_framework_show' => PreferenceType::TextContent,
            'sustainability_overview_policy_framework_file' => PreferenceType::TextFile,
            'sustainability_overview_rating_show' => PreferenceType::TextContent,

            'sustainability_environment_banner' => PreferenceType::TextContentImage,
            'sustainability_environment_overview' => PreferenceType::TextContent,

            'sustainability_social_banner' => PreferenceType::TextContentImage,
            'sustainability_social_overview' => PreferenceType::TextContent,

            'sustainability_governance_banner' => PreferenceType::TextContentImage,
            'sustainability_governance_overview' => PreferenceType::TextContent,

            'sustainability_report_banner' => PreferenceType::TextContentImage,
            'sustainability_action_banner' => PreferenceType::Image,

            'contact_us_main' => PreferenceType::TextContentImage,
            'media_main' => PreferenceType::Image,
            'terms_and_conditions' => PreferenceType::TextContent,
            'privacy_policy' => PreferenceType::TextContent,
            'cookies_consent' => PreferenceType::TextContent,
            'disclaimer' => PreferenceType::TextContent,
            'social_youtube' => PreferenceType::TextContent,
            'social_linkedin' => PreferenceType::TextContent,
            'social_tiktok' => PreferenceType::TextContent,
            'social_x' => PreferenceType::TextContent,
            'social_instagram' => PreferenceType::TextContent,
            'social_facebook' => PreferenceType::TextContent,
            'json_ld_homepage' => PreferenceType::TextContent,
            'json_ld_about_us' => PreferenceType::TextContent,
            'json_ld_governance' => PreferenceType::TextContent,
            'json_ld_sustainability' => PreferenceType::TextContent,
            'json_ld_contact_us' => PreferenceType::TextContent,
            'json_ld_our_business' => PreferenceType::TextContent,
            'llms_txt' => PreferenceType::TextContent,
            'llms_full_txt' => PreferenceType::TextContent,

            'meta_home' => PreferenceType::TextContent,
            'meta_about_us' => PreferenceType::TextContent,
            'meta_about_us_management' => PreferenceType::TextContent,
            'meta_about_us_awards' => PreferenceType::TextContent,
            'meta_our_business' => PreferenceType::TextContent,
            'meta_our_business_energy' => PreferenceType::TextContent,
            'meta_our_business_water' => PreferenceType::TextContent,
            'meta_our_business_ports' => PreferenceType::TextContent,
            'meta_our_business_logistics' => PreferenceType::TextContent,
            'meta_governance' => PreferenceType::TextContent,
            'meta_governance_policy' => PreferenceType::TextContent,
            'meta_governance_whistleblowing' => PreferenceType::TextContent,
            'meta_sustainability' => PreferenceType::TextContent,
            'meta_sustainability_environment' => PreferenceType::TextContent,
            'meta_sustainability_social' => PreferenceType::TextContent,
            'meta_sustainability_governance' => PreferenceType::TextContent,
            'meta_investor_report' => PreferenceType::TextContent,
            'meta_investor_financial' => PreferenceType::TextContent,
            'meta_investor_shares' => PreferenceType::TextContent,
            'meta_investor_publications' => PreferenceType::TextContent,
            'meta_contact_us' => PreferenceType::TextContent,
            'meta_media_news' => PreferenceType::TextContent,
            'meta_terms' => PreferenceType::TextContent,
            'meta_privacy' => PreferenceType::TextContent,
            'meta_cookies' => PreferenceType::TextContent,
            'meta_disclaimer' => PreferenceType::TextContent,

            default => PreferenceType::Text
        };
    }


    public static function getAllHomeKey()
    {
        return [
            self::home_banner->value,
            self::home_banner_tagline->value,
            self::home_about_section->value,
            self::home_infrastructure_title->value,
            self::home_infrastructure_energy->value,
            self::home_infrastructure_water->value,
            self::home_infrastructure_port_storage->value,
            self::home_infrastructure_logistic->value,
            self::home_discover_title->value,
            self::home_discover_sustainability->value,
            self::home_discover_our_business->value,
            self::home_discover_investor->value,
            self::home_discover_career->value,
            self::home_journey_tagline->value,
            self::home_journey_content->value,
            self::home_journey_info_1->value,
            self::home_journey_info_2->value,
            self::home_journey_info_3->value,
            self::json_ld_homepage->value
        ];
    }

    public static function getAllAboutUsKey($type)
    {
        if ($type == 'who-we-are') {
            return [
                self::about_us_banner->value,
                self::about_us_company_overview_tagline->value,
                self::about_us_company_overview->value,
                self::about_us_company_overview_background->value,
                self::about_us_vision_mission_tagline->value,
                self::about_us_vision->value,
                self::about_us_mission->value,
                self::about_us_milestone->value,
                self::about_us_company_profile->value,
                self::about_us_youtube->value,
                self::json_ld_about_us->value
            ];
        }

        if ($type == 'management') {
            return [
                self::about_us_management_banner->value,
                self::about_us_management_overview->value,
                self::about_us_organization_structure->value,
                self::about_us_corporate_structure->value,
                self::about_us_corporate_structure_en->value,
                self::about_us_corporate_structure_id->value,
                self::about_us_corporate_structure_table->value,
                self::about_us_guideline->value,
                self::about_us_corporate_structure_table_show->value,
            ];
        }

        if ($type == 'award') {
            return [
                self::about_us_award_banner->value,
                self::about_us_award_overview->value
            ];
        }

        return [];
    }

    public static function getAllInvestorKey()
    {
        return [
            self::investor_report_banner->value,
            self::investor_report_overview->value,
            self::investor_report_table->value,
            self::investor_financial_banner->value,
            self::investor_share_banner->value,
            self::investor_share_shareholders_table->value,
            self::investor_share_dividend_table->value,
            self::investor_share_bonds_table->value,
            self::investor_publication_banner->value,
            self::investor_share_tab_one->value,
            self::investor_share_tab_two->value,

            self::investor_share_shareholders_table_show->value,
            self::investor_share_dividend_table_show->value,
            self::investor_share_bonds_table_show->value,
            self::investor_report_table_show->value,
        ];
    }

    public static function getAllGovernanceKey()
    {
        return [
            self::governance_banner->value,
            self::governance_corporate_secretary_team->value,
            self::governance_corporate_secretary->value,
            self::governance_internal_audit_unit->value,
            self::governance_audit_committe->value,
            self::governance_audit_committe_member_text->value,
            self::governance_sustainability_committe->value,
            self::governance_risk_management->value,
            self::governance_code_of_conduct->value,
            self::governance_she_regulation->value,
            self::governance_policy->value,
            self::governance_whistleblowing->value,
            self::governance_whistleblowing_id->value,
            self::governance_whistleblowing_detail->value,
            self::governance_audit_committe_show->value,
            self::governance_audit_committe_member_text_show->value,
            self::governance_sustainability_committe_show->value,
            self::governance_risk_management_show->value,
            self::governance_she_regulation_show->value,
            self::governance_policy_show->value,
            self::json_ld_governance->value,
        ];
    }

    public static function getAllOurBusinessKey()
    {
        return [
            self::our_business_banner->value,
            self::our_business_overview->value,
            self::json_ld_our_business->value
        ];
    }

    public static function getSustainabilityKey($type)
    {
        switch ($type) {
            case 'overview':
                return [
                    self::sustainability_overview_banner->value,
                    self::sustainability_overview_content->value,
                    self::sustainability_overview_policy_framework->value,
                    self::sustainability_overview_policy_framework_show->value,
                    self::sustainability_overview_policy_framework_file->value,
                    self::sustainability_overview_rating->value,
                    self::sustainability_overview_rating_show->value,
                    self::json_ld_sustainability->value
                ];
                break;

            case 'environment':
                return [
                    self::sustainability_environment_banner->value,
                    self::sustainability_environment_overview->value
                ];
                break;

            case 'social':
                return [
                    self::sustainability_social_banner->value,
                    self::sustainability_social_overview->value
                ];
                break;

            case 'governance':
                return [
                    self::sustainability_governance_banner->value,
                    self::sustainability_governance_overview->value
                ];
                break;

            case 'report':
                return [
                    self::sustainability_report_banner->value
                ];
                break;

            case 'action':
                return [
                    self::sustainability_action_banner->value
                ];
                break;

            default:
                return [];
                break;
        }
    }

    public static function getAllSustainabilityKey(): array
    {
        return array_merge(
            self::getSustainabilityKey('overview'),
            self::getSustainabilityKey('environment'),
            self::getSustainabilityKey('social'),
            self::getSustainabilityKey('governance'),
            self::getSustainabilityKey('report'),
            self::getSustainabilityKey('action')
        );
    }

    public static function getOtherKeys()
    {
        return [
            self::contact_us_main->value,
            self::terms_and_conditions->value,
            self::media_main->value,
            self::privacy_policy->value,
            self::cookies_consent->value,
            self::disclaimer->value,
            self::social_youtube->value,
            self::social_linkedin->value,
            self::social_tiktok->value,
            self::social_x->value,
            self::social_instagram->value,
            self::social_facebook->value,
            self::email_pic_whistleblowing->value,
            self::json_ld_contact_us->value
        ];
    }

    public static function getLlmsKeys()
    {
        return [
            self::llms_txt->value,
            self::llms_full_txt->value,
        ];
    }

    public static function getSeoMetaKeys(): array
    {
        return [
            self::meta_home->value,
            self::meta_about_us->value,
            self::meta_about_us_management->value,
            self::meta_about_us_awards->value,
            self::meta_our_business->value,
            self::meta_our_business_energy->value,
            self::meta_our_business_water->value,
            self::meta_our_business_ports->value,
            self::meta_our_business_logistics->value,
            self::meta_governance->value,
            self::meta_governance_policy->value,
            self::meta_governance_whistleblowing->value,
            self::meta_sustainability->value,
            self::meta_sustainability_environment->value,
            self::meta_sustainability_social->value,
            self::meta_sustainability_governance->value,
            self::meta_investor_report->value,
            self::meta_investor_financial->value,
            self::meta_investor_shares->value,
            self::meta_investor_publications->value,
            self::meta_contact_us->value,
            self::meta_media_news->value,
            self::meta_terms->value,
            self::meta_privacy->value,
            self::meta_cookies->value,
            self::meta_disclaimer->value,
        ];
    }

}
