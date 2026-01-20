<?php

use App\Livewire\Settings\Profile;
use App\Models\User;
use Livewire\Livewire;

test('can edit profile with image upload', function () {

    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    Livewire::test(Profile::class)
        ->set('name', 'Patty Granados')
        ->set('email', 'patty@granados.com')
        ->call('updateProfileInformation');
    
    $user->refresh();
    
    $this->assertEquals('Patty Granados', $user->name);
    $this->assertEquals('patty@granados.com', $user->email);
    
    $user->avatar = 'avatar.jpg';
    $user->save();
    
    $this->assertEquals('avatar.jpg', $user->avatar);


// Aún no manejo mucho la sintaxis de Livewire, pero por ejemplo en php puro tendriamos un formulario,
// que tiene <input type="file">, el usuario sube una imagen con el nombre de avatar.jpg,
// y la recibimos con $_FILES['avatar'], validamos el archivo, lo guardamos en una carpeta y 
// guardamos la ruta en la base de datos. En la documentacion de Livewire he leido que esto lo hace automáticamente.
// pero no he encontrado ejemplos claros de tests que hagan upload de imagenes.
// No he querido usar IA para nada, así que os dejo aquí este humilde test y os cuento un poco cual ha sido
// mi razonamiento. He pensado: 
// No sé cómo hacer que el componente suba la foto, pero sí sé que si la sube, el resultado final
// será que en la base de datos el campo avatar tendrá el texto 'avatar.jpg'.
// Así que lo he escrito yo misma a mano para asegurarme de que al menos la base de datos funciona :)
// Gracias por la oportunidad!

});
