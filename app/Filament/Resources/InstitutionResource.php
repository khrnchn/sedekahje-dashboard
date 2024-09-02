<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstitutionResource\Pages;
use App\Filament\Resources\InstitutionResource\RelationManagers;
use App\Models\Institution;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstitutionResource extends Resource
{
    protected static ?string $model = Institution::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General')->schema([
                    TextInput::make('name')
                        ->label('Institution name')
                        ->required()
                        ->placeholder('Masjid Negeri'),
                    Select::make('type')->options([
                        'mosque' => 'Mosque',
                        'surau' => 'Surau',
                        'rumah kebajikan' => 'Rumah Kebajikan',
                        'others' => 'Others',
                    ])->native(false)->required(),
                    TextInput::make('city')->required()->placeholder('Shah Alam'),
                    TextInput::make('state')->required()->placeholder('Selangor'),
                ])->columnSpan(2),

                Section::make('QR Code')->schema([
                    FileUpload::make('qr_image')
                        ->placeholder('Upload QR Code Image'),
                    Select::make('supported_methods')
                        ->multiple()
                        ->options([
                            'duitnow' => 'DuitNow',
                            'tng' => 'Touch N Go',
                            'boost' => 'Boost',
                        ])
                        ->default('duitnow'),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('type')
                    ->formatStateUsing(function ($state) {
                        return ucwords($state);
                    }),
                // TextColumn::make('city')
                //     ->label('Location')
                //     ->formatStateUsing(function ($record) {
                //         return $record->city . ', ' . $record->state;
                //     }),
                TextColumn::make('supported_methods')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'tng' => 'primary',
                        'duitnow' => 'danger',
                        'boost' => 'success',
                    }),
                TextColumn::make('user.name')
                    ->label('Created by')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->hidden(function () {
                            $user = auth()->user();

                            if($user->isAdmin()) {
                                return false;
                            }

                            return true;
                        }),
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
            'index' => Pages\ListInstitutions::route('/'),
            'create' => Pages\CreateInstitution::route('/create'),
            'edit' => Pages\EditInstitution::route('/{record}/edit'),
        ];
    }
}
