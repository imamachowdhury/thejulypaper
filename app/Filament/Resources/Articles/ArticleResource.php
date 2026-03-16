<?php

namespace App\Filament\Resources\Articles;

use App\Models\Article;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static string | \UnitEnum | null $navigationGroup = 'Editorial';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Content')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, Set $set) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(Article::class, 'slug', ignoreRecord: true),

                                Forms\Components\Textarea::make('excerpt')
                                    ->rows(3),

                                Forms\Components\RichEditor::make('content')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),

                        Section::make('অতিরিক্ত সূত্র (Additional References)')
                            ->schema([
                                Forms\Components\Repeater::make('references')
                                    ->label('সূত্র তালিকা')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('সূত্রের নাম')
                                            ->placeholder('যেমন: প্রথম আলো রিপোর্ট')
                                            ->required(),
                                        Forms\Components\TextInput::make('url')
                                            ->label('সূত্রের লিংক')
                                            ->placeholder('https://...')
                                            ->url(),
                                    ])
                                    ->columns(2)
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                    ->collapsible()
                                    ->default([]),
                            ]),

                        Section::make('SEO')
                            ->schema([
                                Forms\Components\TextInput::make('meta_title'),
                                Forms\Components\Textarea::make('meta_description'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Status & Visibility')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'pending' => 'Pending Review',
                                        'published' => 'Published',
                                        'scheduled' => 'Scheduled',
                                    ])
                                    ->required()
                                    ->default('draft'),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->default(now()),

                                Forms\Components\TextInput::make('source_name')
                                    ->label('সূত্র (Reference)')
                                    ->placeholder('যেমন: প্রথম আলো'),

                                Forms\Components\TextInput::make('source_url')
                                    ->label('সূত্রের লিংক (Reference URL)')
                                    ->url()
                                    ->placeholder('https://example.com/news'),

                                Forms\Components\Toggle::make('is_featured'),
                            ]),

                        Section::make('Associations')
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->required(),

                                Forms\Components\Select::make('tags')
                                    ->relationship('tags', 'name')
                                    ->multiple()
                                    ->preload(),
                            ]),

                        Section::make('Media')
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->image()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                    ->directory('articles'),
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
                Tables\Columns\ImageColumn::make('featured_image'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'warning',
                        'pending' => 'info',
                        'published' => 'success',
                        'scheduled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'pending' => 'Pending Review',
                        'published' => 'Published',
                        'scheduled' => 'Scheduled',
                    ]),
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\Articles\Pages\ListArticles::route('/'),
            'create' => \App\Filament\Resources\Articles\Pages\CreateArticle::route('/create'),
            'edit' => \App\Filament\Resources\Articles\Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->when(auth()->check() && !auth()->user()->hasAnyRole(['Admin', 'Editor']), function ($query) {
                return $query->where('user_id', auth()->id());
            });
    }
}
