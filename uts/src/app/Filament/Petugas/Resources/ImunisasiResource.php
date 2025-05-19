<?php

namespace App\Filament\Petugas\Resources;

use App\Filament\Petugas\Resources\ImunisasiResource\Pages;
use App\Models\Imunisasi;
use App\Models\Pasien;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ImunisasiResource extends Resource
{
    protected static ?string $model = Imunisasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $modelLabel = 'Imunisasi';

    protected static ?string $navigationLabel = 'Catatan Imunisasi';

    protected static ?string $navigationGroup = 'Data Kesehatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pasien_id')
                    ->label('Nama Pasien')
                    ->required()
                    ->searchable()
                    ->options(
                        Pasien::where('petugas_id', auth()->id())
                            ->pluck('nama', 'id')
                    )
                    ->native(false),
                
                Forms\Components\Select::make('jenis_vaksin')
                    ->required()
                    ->options([
                        'BCG' => 'BCG',
                        'Polio' => 'Polio',
                        'DPT' => 'DPT',
                        'Hepatitis B' => 'Hepatitis B',
                        'Campak' => 'Campak',
                    ])
                    ->native(false),
                
                Forms\Components\DatePicker::make('tanggal')
                    ->required()
                    ->maxDate(now())
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection(),
                
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'Selesai' => 'Selesai',
                        'Tertunda' => 'Tertunda',
                    ])
                    ->native(false)
                    ->default('Selesai'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pasien.nama')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('jenis_vaksin')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('tanggal')
                    ->date('d/m/Y')
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'Selesai',
                        'danger' => 'Tertunda',
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 'Selesai',
                        'heroicon-o-clock' => 'Tertunda',
                    ]),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dicatat Pada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Selesai' => 'Selesai',
                        'Tertunda' => 'Tertunda',
                    ]),
                    
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->beforeFormFilled(function (Imunisasi $record) {
                        // Validasi petugas hanya bisa edit data mereka sendiri
                        if ($record->pasien->petugas_id !== auth()->id()) {
                            abort(403, 'Anda tidak memiliki akses untuk mengedit data ini');
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('tanggal', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('pasien', function ($query) {
                $query->where('petugas_id', auth()->id());
            })
            ->with('pasien'); // Eager loading untuk optimasi
    }

    public static function canDelete(Model $record): bool
    {
        // Hanya boleh hapus jika data dibuat hari ini
        return $record->created_at->isToday();
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