<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
    Role, Event, Service,
    EventResource, EventSecurity, ActivityEvent,
    Payment, Feedback, Notification, Message,
    Support, EventService
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        //Roles
        Role::create(['name' => 'organizador']);
        Role::create(['name' => 'proveedor']);
        Role::create(['name' => 'usuario']);

        //10 usuarios aleatorios y asigna rol
        $users = User::factory(10)->create();
        foreach ($users as $user) {
            $user->roles()->attach(rand(1, 3));
        }

        //Crea 5 servicios
        $services = Service::factory(5)->create();

        //Asigna 2 usuarios a cada servicio
        foreach ($services as $service) {
            $randomUsers = $users->random(2);
            foreach ($randomUsers as $user) {
                $service->users()->attach($user->id);
            }
        }
        //Crea 3 eventos con rol organizador
        $events = Event::factory(3)->create([
            'organizer_id' => $users[0]->id
        ]);

        //Por cada evento creado 
        foreach ($events as $event) {
            //Crea recursos, seguridad y actividad relacionada al evento
            EventResource::factory()->create(['event_id' => $event->id]);
            EventSecurity::factory()->create(['event_id' => $event->id]);
            ActivityEvent::factory()->create(['event_id' => $event->id]);

            //Relaciona los dos primeros usuarios con evento 
            foreach ($users->take(2) as $user) {
                $event->users()->attach($user->id);

                //Crea pagos para estos usuarios en este evento
                Payment::factory()->create([
                    'user_id' => $user->id,
                    'event_id' => $event->id
                ]);

                //Crear feedback del evento con esos usuarios
                Feedback::factory()->create([
                    'user_id' => $user->id,
                    'event_id' => $event->id
                ]);
            }

            //Relaciona un servicio y un proveedor al evento
            EventService::factory()->create([
                'event_id' => $event->id,
                'service_id' => $services[0]->id,
                'provider_id' => $users[1]->id
            ]);
        }

        //Crea una notificación y un soporte por cada usuario
        foreach ($users as $user) {
            Notification::factory()->create(['user_id' => $user->id]);
            Support::factory()->create(['user_id' => $user->id]);
        }

        //Crea un mensaje entre el primer y segundo usuario
        Message::factory()->create([
            'sender_id' => $users[0]->id,
            'receiver_id' => $users[1]->id
        ]);
    }
}
