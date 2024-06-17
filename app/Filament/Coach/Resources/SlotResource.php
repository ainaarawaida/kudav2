<?php

namespace App\Filament\Coach\Resources;

use Closure;
use Filament\Forms;
use App\Models\Slot;
use Filament\Tables;
use App\Models\Coach;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Coach\Resources\SlotResource\Pages;
use App\Filament\Coach\Resources\SlotResource\RelationManagers;
use App\Filament\Coach\Resources\SlotResource\RelationManagers\SlotHorseRelationManager;

class SlotResource extends Resource
{
    protected static ?string $model = Slot::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
            return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Class Name')   
                    ->maxLength(255)
                    ->required()
                    ->disabled(fn($operation) => $operation == 'edit'),
                Forms\Components\DatePicker::make('date')
                    
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(now())
                    ->disabled(fn($operation) => $operation == 'edit')
                
                    ->live(onBlur:true)
                    ->required(),
                Forms\Components\Select::make('time_id') 
                    ->label('Time')  
                    ->relationship(name: 'time', titleAttribute: 'name') 
                    ->disableOptionWhen(function (string $value, Get $get, string $operation, ?string $state): bool {
                        // dd($get('date'));
                        $findSlotNotAvailable = Slot::where('date', date("Y-m-d", strtotime($get('date'))) )->get()->pluck('time_id')->toArray();
                        if($operation == 'edit'){
                            return in_array($value, $findSlotNotAvailable) && $value != $state;
                        }
                        return in_array($value, $findSlotNotAvailable);
                    })
                    ->rules([
                        fn (Get $get, string $operation, ?string $state): Closure => function (string $attribute, $value, Closure $fail) use($get, $operation,$state) {
                            $findSlotNotAvailable = Slot::where('date', date("Y-m-d", strtotime($get('date'))) )->get()->pluck('time_id')->toArray();
                            if($operation == 'edit'){
                                if(in_array($value, $findSlotNotAvailable) && $value != $state){
                                    $fail('The :attribute is not available.');
                                };
                            }else{
                                if(in_array($value, $findSlotNotAvailable)){
                                    $fail('The :attribute is not available.');
                                };
                            }

                        
                        },
                    ])
                    ->disabled(fn($operation) => $operation == 'edit')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('horses.name')
                    ->badge()
                    ->color('danger')
                    ->label('Horses')   
                    ->searchable(),
                Tables\Columns\TextColumn::make('riders.name')
                    ->badge()
                    ->color('info')
                    ->label('Riders')   
                    ->searchable(),

                Tables\Columns\TextColumn::make('coaches.name')
                    ->badge()
                    ->color('primary')
                    ->label('Coaches')   
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Class Name')   
                    ->searchable(),
                Tables\Columns\TextColumn::make('time.name')
        
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make('date')
                    ->form([
                        DatePicker::make('date_at')
                        ->label('Slot Date' )
                        ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_at'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '=', $date),
                            );
                    }),
                    Tables\Filters\SelectFilter::make('Horse')
                        ->relationship('horses', 'name')
                        ->searchable()
                        ->preload()
                        ->label('Filter by Horse')
                        ->indicator('Horse'),

                        
                        Tables\Filters\SelectFilter::make('Coach')
                            ->relationship('coaches', 'name')
                            ->default(Coach::where('user_id', Auth::id())->first()?->id)
                            ->searchable()
                            ->preload()
                            ->label('Filter by Coach')
                            ->indicator('Coach'),

                        Tables\Filters\SelectFilter::make('Rider')
                            ->relationship('riders', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Filter by Rider')
                            ->indicator('Rider'),

                
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ])
                ->label('More actions')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(ActionSize::Small)
                ->color('primary')
                ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\ForceDeleteBulkAction::make(),
                    // Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            SlotHorseRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSlots::route('/'),
            // 'create' => Pages\CreateSlot::route('/create'),
            'view' => Pages\ViewSlot::route('/{record}'),
            'edit' => Pages\EditSlot::route('/{record}/edit'),
        ];
    }
}
