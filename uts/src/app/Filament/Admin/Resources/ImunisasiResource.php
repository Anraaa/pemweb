<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ImunisasiResource\Pages;
use App\Filament\Admin\Resources\ImunisasiResource\RelationManagers;
use App\Models\Imunisasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImunisasiResource extends Resource
{
    protected static ?string $model = Imunisasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pasien_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('jenis_vaksin')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pasien_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_vaksin'),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImunisasis::route('/'),
            'create' => Pages\CreateImunisasi::route('/create'),
            'edit' => Pages\EditImunisasi::route('/{record}/edit'),
        ];
    }
}
