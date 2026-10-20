<?php

namespace App\Enums;

enum InvestorReportType: string
{
    case AnnualReport = 'annual_report';
    case FinancialReport = 'financial_report';
    case Prospectus = 'prospectus';
    case GMS = 'gms';
    case Disclosure = 'disclosure';
    case CompanyOverview = 'company_overview';
    case InvestorUpdate = 'investor_update';
    case EarningsUpdate = 'earnings_update';

    public function word()
    {
        return match ($this->value) {
            'annual_report' => 'Annual Report',
            'financial_report' => 'Financial Report',
            'prospectus' => 'Prospectus',
            'gms' => 'GMS',
            'disclosure' => 'Public Announcement',
            'company_overview' => 'Company Overview',
            'investor_update' => 'Investor Update',
            'earnings_update' => 'Earnings Update'
        };
    }
}
