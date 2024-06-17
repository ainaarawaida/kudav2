<?php

namespace App\Filament\Coach\Widgets;

use App\Models\SlotHorse;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Coach\Resources\SlotResource;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CoachCalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = SlotHorse::class;
    
    public function fetchEvents(array $fetchInfo): array
    {
  
        return SlotHorse::query()->with(['slots','horse'])
            ->where('coach_id', auth()->user()->coach?->id)
            ->get()
            ->map(
                fn (SlotHorse $event) => [
                    'title' => $event->slots->time->name . ' - ' . $event->slots->name  ,
                    'start' => $event->slots->date,
                    'end' => $event->slots->date,
                    'url' => SlotResource::getUrl(name: 'edit', parameters: ['record' => $event->slot_id]),
                    'shouldOpenUrlInNewTab' => false,
                    'time' => $event->slots->time->name, 
                    'horse' => $event->horse, 
                    'coach' => $event->coach,
                    'rider' => $event->rider,
                ]
            )
            ->all();
    }

    public function eventDidMount(): string
    {
        return <<<JS
            function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
                console.log("event",event.extendedProps.horse)
                let render = "Class Name: " + event.title + "<br>" + 
                "Time: " + event.extendedProps.time + "<br>" +
                "Horse: " + event.extendedProps.horse?.name + "<br>" +
                "Coach: " + event.extendedProps.coach?.name + "<br>" +
                "Rider: " + event.extendedProps.rider?.name + "<br>" ; 

                el.setAttribute("x-tooltip.html", "tooltip");
                el.setAttribute("x-data", "{ tooltip: '"+render+"' }");
                // var tooltip = new Tooltip(info.el, {
                //     title: info.event.title,
                //     placement: 'top',
                //     trigger: 'hover',
                //     container: 'body'
                // });

            }
        JS;
    }

    protected function headerActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

   
}
