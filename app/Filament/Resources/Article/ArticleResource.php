<?php

namespace App\Filament\Resources\Article;

use App\Filament\Resources\Article\ArticleResource\Pages;
use App\Models\Article\Article;
use App\Models\Article\ArticleCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Media & News';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Tabs::make('Article Content')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('🇬🇧 English')
                                    ->schema([
                                        Forms\Components\TextInput::make('title_en')
                                            ->label('Title (English)')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($state, Forms\Set $set, $get) {
                                                if (empty($get('slug'))) {
                                                    $set('slug', Str::slug($state));
                                                }
                                            }),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug (English)')
                                            ->required()
                                            ->unique(Article::class, 'slug', ignoreRecord: true),
                                        Forms\Components\RichEditor::make('content_en')
                                            ->label('Content (English)')
                                            ->required(),
                                        Forms\Components\Grid::make(2)->schema([
                                            Forms\Components\TextInput::make('thumbnail_alt_en')
                                                ->label('Thumbnail Alt Text (English)'),
                                            Forms\Components\TextInput::make('thumbnail_caption_en')
                                                ->label('Thumbnail Caption (English)'),
                                        ]),
                                    ]),

                                Forms\Components\Tabs\Tab::make('🇮🇩 Bahasa Indonesia')
                                    ->schema([
                                        Forms\Components\TextInput::make('title_id')
                                            ->label('Title (Indonesian)')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($state, Forms\Set $set, $get) {
                                                if (empty($get('slug_id'))) {
                                                    $set('slug_id', Str::slug($state));
                                                }
                                            }),
                                        Forms\Components\TextInput::make('slug_id')
                                            ->label('Slug (Indonesian)')
                                            ->required(),
                                        Forms\Components\RichEditor::make('content_id')
                                            ->label('Content (Indonesian)')
                                            ->required(),
                                        Forms\Components\Grid::make(2)->schema([
                                            Forms\Components\TextInput::make('thumbnail_alt_id')
                                                ->label('Thumbnail Alt Text (Indonesian)'),
                                            Forms\Components\TextInput::make('thumbnail_caption_id')
                                                ->label('Thumbnail Caption (Indonesian)'),
                                        ]),
                                    ]),

                                Forms\Components\Tabs\Tab::make('SEO & Structured Data')
                                    ->schema([
                                        Forms\Components\KeyValue::make('meta_tag')
                                            ->label('Meta Tags (English)'),
                                        Forms\Components\KeyValue::make('meta_tag_id')
                                            ->label('Meta Tags (Indonesian)'),
                                        Forms\Components\Textarea::make('json_ld')
                                            ->label('JSON-LD Schema (English)')
                                            ->rows(3),
                                        Forms\Components\Textarea::make('json_ld_id')
                                            ->label('JSON-LD Schema (Indonesian)')
                                            ->rows(3),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Publishing & Metadata')
                            ->schema([
                                Forms\Components\Select::make('category')
                                    ->options([
                                        'news' => 'News',
                                        'blog' => 'Blog',
                                    ])
                                    ->default('news')
                                    ->required(),
                                Forms\Components\Select::make('article_category_id')
                                    ->label('Topic Category')
                                    ->relationship('articleCategory', 'name_en'),
                                Forms\Components\Toggle::make('status')
                                    ->label('Published')
                                    ->default(true),
                                Forms\Components\DateTimePicker::make('datetime')
                                    ->label('Publish Date')
                                    ->default(now())
                                    ->required(),
                                Forms\Components\TagsInput::make('tags')
                                    ->label('Tags'),
                                Forms\Components\TextInput::make('thumbnail')
                                    ->label('Thumbnail URL / Path')
                                    ->helperText('Relative storage path or full URL'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title')
                    ->searchable(['title_en', 'title_id'])
                    ->limit(40)
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('category')
                    ->colors([
                        'primary' => 'news',
                        'warning' => 'blog',
                    ]),
                Tables\Columns\TextColumn::make('articleCategory.name_en')
                    ->label('Category')
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('datetime')
                    ->label('Published At')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'news' => 'News',
                        'blog' => 'Blog',
                    ]),
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Published Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('datetime', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
