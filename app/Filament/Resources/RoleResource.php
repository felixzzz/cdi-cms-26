<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'System Settings';

    protected static ?string $navigationLabel = 'Roles & Permissions';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return itcan('system_settings');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Role Definition')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Role Name')
                            ->placeholder('e.g. Content Editor, Compliance Officer, Investor Relations')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\Toggle::make('is_superadmin')
                            ->label('Full Superadmin Access')
                            ->helperText('Enables unrestricted access across all CMS resources and settings.')
                            ->default(false)
                            ->live(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Granular Permissions')
                    ->description('Select the CMS sections and features accessible by members assigned to this role.')
                    ->schema([
                        Forms\Components\CheckboxList::make('permissions')
                            ->label('')
                            ->options([
                                'page_management' => 'Page Management (Home, About Us, Business, Sustainability, Investor, Governance, Global Settings, SEO)',
                                'articles' => 'Media & Articles (News & Blog Publishing)',
                                'press_releases' => 'Press Releases & Publications',
                                'our_business' => 'Business Sectors & Subsidiaries',
                                'investor_reports' => 'Investor Reports & Financial Disclosures',
                                'sustainability' => 'Sustainability Content & Reports',
                                'corporate_data' => 'Corporate Data (Offices, Teams, Certificates, Awards)',
                                'inbox_contact' => 'Public Inquiries (General Contact Forms)',
                                'inbox_whistleblowing' => 'Whistleblowing Submissions (Confidential Reports)',
                                'system_settings' => 'System Administration (Users, Roles, Quick Links, Preferences)',
                            ])
                            ->columns(2)
                            ->bulkToggleable(),
                    ])
                    ->visible(fn (Forms\Get $get): bool => ! (bool) $get('is_superadmin')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Role Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\IconColumn::make('is_superadmin')
                    ->label('Superadmin')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Assigned Users')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('permissions')
                    ->label('Module Access')
                    ->formatStateUsing(function ($state, Role $record): string {
                        if ($record->is_superadmin) {
                            return 'All Modules (Unrestricted)';
                        }
                        $perms = is_array($state) ? $state : (json_decode($state ?? '', true) ?? []);
                        return count($perms) > 0 ? count($perms) . ' permissions granted' : 'No permissions assigned';
                    })
                    ->badge()
                    ->color(fn ($state, Role $record) => $record->is_superadmin ? 'success' : 'gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Role $record): bool => ! $record->is_superadmin && $record->users()->count() === 0),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
