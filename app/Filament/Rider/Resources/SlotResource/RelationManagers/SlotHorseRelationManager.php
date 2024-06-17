<?php

namespace App\Filament\Rider\Resources\SlotResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Coach;
use App\Models\Horse;
use App\Models\Rider;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\SlotHorse;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SlotHorseRelationManager extends RelationManager
{
    protected static string $relationship = 'slot_horse';

    public function attachForm()
    {
        return Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Select::make('horse_id')
                    ->label('Horse')   
                    ->relationship(name: 'horse', titleAttribute: 'name') 
                    // ->options(function(RelationManager $livewire, $state) {
                    //     $horse = Horse::whereDoesntHave('slots', function($q) use($livewire) {
                    //         $q->whereDate('slots.date', $livewire->getOwnerRecord()->date)
                    //         ->where('slots.time_id', $livewire->getOwnerRecord()->time_id);
                    //     })
                    //     ->orWhere('id', $state)->get()->pluck('name', 'id');
                    //     return $horse;
                    // })
                    ->disableOptionWhen(function (RelationManager $livewire,string $value, Get $get, string $operation, ?string $state, $record): bool {
                        $available =  Horse::whereDoesntHave('slots', function($q) use($livewire) {
                                    $q->where('slots.id', $livewire->getOwnerRecord()->id);
                                })->pluck('id')->toArray();
                                
                        if($operation == 'edit'){
                            return !in_array($value, $available) && $value != $record->horse_id;
                        }
                        return !in_array($value, $available);
                    })
                    ->rules([
                        fn (RelationManager $livewire,Get $get, string $operation, ?string $state, $record): Closure => function (string $attribute, $value, Closure $fail) use($get, $operation,$state, $livewire, $record) {
                            $available =  Horse::whereDoesntHave('slots', function($q) use($livewire) {
                                $q->where('slots.id', $livewire->getOwnerRecord()->id);
                            })->pluck('id')->toArray();
                            if($operation == 'edit'){
                                if(!in_array($value, $available) && $value != $record->horse_id){
                                    $fail('The :attribute is not available.');
                                };
                            }else{
                                if(!in_array($value, $available)){
                                    $fail('The :attribute is not available.');
                                };
                            }

                        
                        },
                    ])
                    ->searchable()
                    ->preload()
                    ->disabled(fn($operation) => $operation == 'edit')
                    ->required(),
                Forms\Components\Select::make('coach_id')
                    ->label('Coach')   
                    ->relationship(name: 'coach', titleAttribute: 'name') 
                    ->disableOptionWhen(function (RelationManager $livewire,string $value, Get $get, string $operation, ?string $state, $record): bool {

                        $available =  Coach::whereDoesntHave('slots', function($q) use($livewire) {
                                    $q->where('slots.id', $livewire->getOwnerRecord()->id);
                                })->pluck('id')->toArray();
                        if($operation == 'edit'){
                            return !in_array($value, $available) && $value != $record->coach_id;
                        }
                        return !in_array($value, $available);
                    })
                    ->rules([
                        fn (RelationManager $livewire,Get $get, string $operation, ?string $state,$record): Closure => function (string $attribute, $value, Closure $fail) use($get, $operation,$state, $livewire, $record) {
                            $available =  Coach::whereDoesntHave('slots', function($q) use($livewire) {
                                $q->where('slots.id', $livewire->getOwnerRecord()->id);
                            })->pluck('id')->toArray();
                            if($operation == 'edit'){
                                if(!in_array($value, $available) && $value != $record->coach_id){
                                    $fail('The :attribute is not available.');
                                };
                            }else{
                                if(!in_array($value, $available)){
                                    $fail('The :attribute is not available.');
                                };
                            }

                        
                        },
                    ])
                    ->disabled(fn($operation) => $operation == 'edit')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('rider_id')
                    ->label('Rider')  
                    ->relationship(name: 'rider', titleAttribute: 'name')  
                    ->options(function(RelationManager $livewire, $state) {
                        $rider = Rider::where('user_id', auth()->user()->id)->pluck('name', 'id');
                        return $rider;
                    })
                    ->disableOptionWhen(function (RelationManager $livewire,string $value, Get $get, string $operation, ?string $state, $record): bool {
                        $available =  collect(DB::select("SELECT a.id, a.name
                             FROM riders a
                             WHERE a.id NOT IN (
                             SELECT CASE 
                                 WHEN rider_id IS NULL THEN 0
                                 ELSE rider_id
                                 END
                                 rider_id from slot_horse WHERE slot_id = ?
                             ) OR a.id = ?", [$livewire->getOwnerRecord()->id, $state]))->pluck('id')->toArray();


                        if($operation == 'edit'){
                            return !in_array($value, $available) && $value != $record->rider_id;
                        }
                        return !in_array($value, $available);
                    })
                    ->rules([
                        fn (RelationManager $livewire,Get $get, string $operation, ?string $state, $record): Closure => function (string $attribute, $value, Closure $fail) use($get, $operation,$state, $livewire, $record) {
                            $available =  collect(DB::select("SELECT a.id, a.name
                             FROM riders a
                             WHERE a.id NOT IN (
                             SELECT CASE 
                                 WHEN rider_id IS NULL THEN 0
                                 ELSE rider_id
                                 END
                                 rider_id from slot_horse WHERE slot_id = ?
                             ) OR a.id = ?", [$livewire->getOwnerRecord()->id, $record->rider_id]))->pluck('id')->toArray();


                            if($operation == 'edit'){
                                if(!in_array($value, $available) && $value != $record->rider_id){
                                    $fail('The :attribute is not available.');
                                };
                            }else{
                                if(!in_array($value, $available)){
                                    $fail('The :attribute is not available.');
                                };
                            }

                        
                        },
                    ])
                  
                    ->searchable()
                    ->preload(),
                ]);
        
    }

   
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('horse_id')
            ->columns([
                Tables\Columns\TextColumn::make('horse.name')
                    ->label('Horse'),
                Tables\Columns\TextColumn::make('coach.name')
                    ->label('Coach') ,
                Tables\Columns\TextColumn::make('rider.name')
                    ->label('Rider') ,
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\Action::make('attach')
                //     ->label('Attach Horse') 
                //     ->form([
                //         $this->attachForm(),
                //     ])
                //     ->action(function (RelationManager $livewire, $data) {
                //         $slot_horse = SlotHorse::create([
                //             'slot_id' => $livewire->ownerRecord->id,
                //             'horse_id' => $data['horse_id'],
                //             'coach_id' => $data['coach_id'],
                //             'rider_id' => $data['rider_id'],
                //         ]);

                //         Notification::make()
                //         ->title('Created successfully')
                //         ->success()
                //         ->send();

                //         // $slot = Slot::find($livewire->ownerRecord->id) ;
                //         // $slot->horses()->attach($data['horse_id'], ['coach_id' => $data['coach_id'], 'rider_id' => $data['rider_id']]);
                //     }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label('Edit')
                ->visible(fn($record) => $record->rider_id == auth()->user()->rider?->id || $record->rider_id == null)
                ->form([
                    $this->attachForm(),
                ])
                ->action(function (RelationManager $livewire, $data, $record) {

                    $slot_horse = SlotHorse::where('id', $record->id)
                    ->update([
                        'coach_id' => $data['coach_id'],
                    ]);

                    Notification::make()
                    ->title('Upadated successfully')
                    ->success()
                    ->send();



                }),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
