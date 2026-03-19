<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use App\Filament\Resources\BookResource\RelationManagers;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;


    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Books';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->directory('book-covers')
                    ->disk('public'),

                Forms\Components\TextInput::make('title')
                    ->required(),

                Forms\Components\MultiSelect::make('authors')
                    ->relationship('authors', 'name')
                    ->label('Authors')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\MultiSelect::make('categories')
                    ->relationship('categories', 'name')
                    ->label('Categories')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('publisher_id')
                    ->relationship('publisher', 'name')
                    ->label('Publisher')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->editOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->required(),

                Forms\Components\TextInput::make('isbn'),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),

                Forms\Components\Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'borrowed' => 'Borrowed',
                    ])
                    ->default('available'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Book Picture')
                    ->disk('public'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Book Title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('publisher.name')
                    ->label('Publisher'),

                Tables\Columns\TextColumn::make('authors.name')
                    ->label('Authors')
                    ->badge(),

                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Categories')
                    ->badge(),

                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\ImageEntry::make('cover_image')
                    ->label('Book Picture')
                    ->disk('public'),

                Infolists\Components\TextEntry::make('title')
                    ->label('Book Title'),

                Infolists\Components\TextEntry::make('authors.name')
                    ->label('Authors')
                    ->badge(),

                Infolists\Components\TextEntry::make('publisher.name')
                    ->label('Publisher'),

                Infolists\Components\TextEntry::make('categories.name')
                    ->label('Categories')
                    ->badge(),

                Infolists\Components\TextEntry::make('isbn')
                    ->label('ISBN'),

                Infolists\Components\TextEntry::make('description')
                    ->label('Description')
                    ->columnSpanFull(),

                Infolists\Components\TextEntry::make('status')
                    ->label('Status'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AuthorRelationManager::class,
            RelationManagers\CategoryRelationManager::class,
            RelationManagers\PublisherRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
            'view' => Pages\ViewBook::route('/{record}'),
        ];
    }
}
