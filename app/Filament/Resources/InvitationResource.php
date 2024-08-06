<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvitationResource\Pages;
use App\Filament\Resources\InvitationResource\RelationManagers;
use App\Models\Invitation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;

class InvitationResource extends Resource
{
    protected static ?string $model = Invitation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make(name: 'email')->email(),
                Forms\Components\TextInput::make(name: 'addressTo'),
                Forms\Components\Select::make('gender')
                ->options([
                    false => 'male',
                    true => 'female',
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'email'),
                Tables\Columns\TextColumn::make(name: 'addressTo'),
                Tables\Columns\TextColumn::make(name: 'token'),
                Tables\Columns\TextColumn::make(name: 'gender_text')
                    ->label('Gender')
                    ->badge(),
                Tables\Columns\BooleanColumn::make(name: 'accepted'),
                Tables\Columns\BooleanColumn::make(name: 'responded'),
                Tables\Columns\BooleanColumn::make(name: 'sent'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('send_invites')
                        ->label('Send Invites')
                        ->icon('heroicon-m-envelope')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->sendEmail())
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])->checkIfRecordIsSelectableUsing(
                fn (Invitation $record): bool => $record->sent == false,
            );
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
            'index' => Pages\ListInvitations::route('/'),
            'create' => Pages\CreateInvitation::route('/create'),
            'edit' => Pages\EditInvitation::route('/{record}/edit'),
        ];
    }
}
