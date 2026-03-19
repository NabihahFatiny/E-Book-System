<?php

namespace App\Filament\Resources\PublisherResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->directory('book-covers')
                    ->disk('public'),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

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

                Forms\Components\TextInput::make('isbn')
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),

                Forms\Components\Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'borrowed' => 'Borrowed',
                    ])
                    ->default('available')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Book Picture')
                    ->disk('public'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Book Title')
                    ->searchable(),

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
                    ->label('Status')
                    ->badge(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
