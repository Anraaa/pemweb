<?php

namespace App\Filament\Petugas\Resources;

use App\Filament\Petugas\Resources\PasienResource\Pages;
use App\Models\Pasien;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PasienResource extends Resource
{
    protected static ?string $model = Pasien::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $modelLabel = 'Pasien';

    protected static ?string $navigationLabel = 'Data Pasien';

    protected static ?string $navigationGroup = 'Manajemen Data';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Pasien')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->label('Foto Pasien')
                            ->image()
                            ->directory('pasien-photos')
                            ->maxSize(2048) // 2MB
                            ->columnSpanFull(),
                            
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->length(16)
                            ->numeric()
                            ->mask('9999999999999999'),
                            
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->maxDate(now()),
                            
                        Forms\Components\Select::make('jenis_kelamin')
                            ->required()
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->native(false),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Data Orang Tua')
                    ->schema([
                        Forms\Components\TextInput::make('nama_ortu')
                            ->label('Nama Orang Tua')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                    
                Forms\Components\Hidden::make('petugas_id')
                    ->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->nama).'&color=FFFFFF&background=4f46e5'),
                    
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Usia')
                    ->formatStateUsing(fn ($state) => $state->age.' tahun')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('JK')
                    ->formatStateUsing(fn ($state) => $state == 'L' ? 'Laki-laki' : 'Perempuan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'L' => 'primary',
                        'P' => 'success',
                    }),
                    
                Tables\Columns\TextColumn::make('nama_ortu')
                    ->label('Orang Tua')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
                    
                Tables\Filters\Filter::make('umur')
                    ->form([
                        Forms\Components\TextInput::make('min_umur')
                            ->numeric()
                            ->placeholder('Min'),
                        Forms\Components\TextInput::make('max_umur')
                            ->numeric()
                            ->placeholder('Max'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_umur'],
                                fn (Builder $query, $age): Builder => $query->where('tanggal_lahir', '<=', now()->subYears($age)),
                            )
                            ->when(
                                $data['max_umur'],
                                fn (Builder $query, $age): Builder => $query->where('tanggal_lahir', '>=', now()->subYears($age)),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->before(function ($record) {
                            // Prevent deletion if patient has immunization records
                            if ($record->imunisasi()->exists()) {
                                throw new \Exception('Pasien tidak bisa dihapus karena memiliki riwayat imunisasi');
                            }
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->imunisasi()->exists()) {
                                    throw new \Exception('Beberapa pasien memiliki riwayat imunisasi dan tidak bisa dihapus');
                                }
                            }
                        }),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('petugas_id', auth()->id())
            ->withCount('imunisasi'); // For potential badge display
    }

    public static function getRelations(): array
    {
        return [
            // Add RelationManagers for Imunisasi if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPasiens::route('/'),
            'create' => Pages\CreatePasien::route('/create'),
            'edit' => Pages\EditPasien::route('/{record}/edit'),
        ];
    }
}