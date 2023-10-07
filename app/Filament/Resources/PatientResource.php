<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Filament\Resources\PatientResource\RelationManagers\TreatmentsRelationManager;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('宠物名称')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->label('宠物类型')
                    ->options([
                        'cat' => '猫',
                        'dog' => '狗',
                        'rabbit' => '兔子',
                    ])
                    ->required(),

                DatePicker::make('date_of_birth')
                    ->label('出生日期')
                    ->required()
                    ->maxDate(now()),

                Select::make('owner_id')
                    ->label('主人')
                    ->relationship('owner', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('主人名称')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('电子邮箱')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('手机号码')
                            ->tel()
                            ->required(),
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('宠物名称')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('宠物类型'),
                TextColumn::make('date_of_birth')
                    ->label('出生日期')
                    ->sortable(),
                TextColumn::make('owner.name')
                    ->label('主人名称')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('宠物类型')
                    ->options([
                        'cat' => '猫',
                        'dog' => '狗',
                        'rabbit' => '兔子',
                    ]),
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
            TreatmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
