<?php

namespace App\Enums;

enum AdditionalFileType: string
{
    case CompanyProfile = 'company_profile';
    case Guideline = 'guideline';
    case InternalAudit = 'internal_audit';
    case CorporateSecretary = 'corporate_secretary';
    case AuditCommitte = 'audit_committe';
    case SustainabilityCommitte = 'sustainability_committe';
    case RiskManagement = 'risk_management';
    case CodeOfConduct = 'code_of_conduct';
    case SHERegulation = 'she_regulation';
    case Policy = 'policy';

    public function word()
    {
        return match ($this->value) {
            'company_profile' => 'Company Profile',
            'guideline' => 'Guideline',
            'internal_audit' => 'Internal Audit',
            'corporate_secretary' => 'Corporate Secretary',
            'audit_committe' => 'Audit Committe',
            'sustainability_committe' => 'Sustainability Committe',
            'risk_management' => 'Risk Management',
            'code_of_conduct' => 'Code of Conduct',
            'she_regulation' => "SHE Regulation",
            'policy' => 'policy'
        };
    }
}
