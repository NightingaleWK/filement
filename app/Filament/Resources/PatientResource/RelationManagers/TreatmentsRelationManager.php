<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TreatmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'treatments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->label('病情简述')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
                Forms\Components\Textarea::make('notes')
                    ->label('病情详情')
                    ->maxLength(65535)
                    ->columnSpan('full'),
                Forms\Components\TextInput::make('price')
                    ->label('收费')
                    ->numeric()
                    ->prefix('￥')
                    ->maxValue(42949672.95),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('病情简述'),
                Tables\Columns\TextColumn::make('price')
                    ->label('收费')
                    ->money('CNY')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('创建时间')
                    ->dateTime('Y-m-d h:i A'),
            ])
            ->filters([
                //
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
