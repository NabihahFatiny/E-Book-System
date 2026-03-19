<?php

namespace App\Filament\Resources\BookResource\RelationManagers;

use App\Models\Publisher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PublisherRelationManager extends RelationManager
{
    protected static string $relationship = 'publisher';

    protected static ?string $title = 'Publisher';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('assignPublisher')
                    ->label(fn (): string => $this->getOwnerRecord()->publisher_id ? 'Change publisher' : 'Assign publisher')
                    ->form([
                        Forms\Components\Select::make('publisher_id')
                            ->label('Publisher')
                            ->options(Publisher::query()->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->fillForm(fn (): array => [
                        'publisher_id' => $this->getOwnerRecord()->publisher_id,
                    ])
                    ->action(function (array $data): void {
                        $this->getOwnerRecord()->update([
                            'publisher_id' => $data['publisher_id'],
                        ]);
                    }),
                Tables\Actions\CreateAction::make('createPublisher')
                    ->label('New publisher')
                    ->model(Publisher::class)
                    ->using(function (array $data): Publisher {
                        $publisher = Publisher::create($data);

                        $this->getOwnerRecord()->update([
                            'publisher_id' => $publisher->id,
                        ]);

                        return $publisher;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('removePublisher')
                    ->label('Remove')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (): void {
                        $this->getOwnerRecord()->update([
                            'publisher_id' => null,
                        ]);
                    }),
            ]);
    }

    protected function getTableQuery(): Builder
    {
        $publisherId = $this->getOwnerRecord()->publisher_id;

        return Publisher::query()->whereKey($publisherId ?? 0);
    }
}
