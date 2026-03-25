<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BorrowingResource\Pages;
use App\Models\Borrowing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BorrowingResource extends Resource
{
    protected static ?string $model = Borrowing::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-circle';

    protected static ?string $navigationLabel = 'Borrowings';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('book_id')
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\DateTimePicker::make('borrowed_at')
                    ->required(),

                Forms\Components\DateTimePicker::make('due_at')
                    ->required(),

                Forms\Components\DateTimePicker::make('returned_at'),

                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'returned' => 'Returned',
                    ])
                    ->required(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['user', 'book']))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->description(fn (Borrowing $record): string => $record->user?->email ?? '-')
                    ->searchable(['name', 'email']),

                Tables\Columns\TextColumn::make('book.title')
                    ->label('Book')
                    ->description(fn (Borrowing $record): string => $record->book?->isbn ?? '-')
                    ->searchable(),

                Tables\Columns\TextColumn::make('borrowed_at')
                    ->label('Borrowed At')
                    ->dateTime('d M Y h:i A')
                    ->sortable(),

                Tables\Columns\TextColumn::make('due_at')
                    ->label('Due At')
                    ->dateTime('d M Y h:i A')
                    ->sortable(),

                Tables\Columns\TextColumn::make('returned_at')
                    ->label('Returned At')
                    ->formatStateUsing(fn ($state): string => $state ? $state->format('d M Y h:i A') : '-')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'warning',
                        'returned' => 'success',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('borrowed_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'returned' => 'Returned',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('markReturned')
                    ->label('Returned')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (Borrowing $record): bool => $record->status === 'active')
                    ->action(function (Borrowing $record): void {
                        $record->update([
                            'status' => 'returned',
                            'returned_at' => now(),
                        ]);

                        if (! $record->book->borrowings()->where('status', 'active')->exists()) {
                            $record->book->update(['status' => 'available']);
                        }
                    }),

                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBorrowings::route('/'),
            'create' => Pages\CreateBorrowing::route('/create'),
            'edit' => Pages\EditBorrowing::route('/{record}/edit'),
        ];
    }
}
