<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoEspacio;
use App\Models\Espacio;
use App\Models\Comodidad;
use App\Models\User;

class SemillaCowork extends Seeder
{
    public function run()
    {
        // Tipos de espacio
        $escritorio = TipoEspacio::create([
            'nombre' => 'Escritorio compartido',
            'descripcion' => 'Puesto de trabajo en área abierta, ideal para freelancers.'
        ]);
        $sala = TipoEspacio::create([
            'nombre' => 'Sala de reuniones',
            'descripcion' => 'Salas privadas para equipos, con equipamiento para presentaciones.'
        ]);
        $oficina = TipoEspacio::create([
            'nombre' => 'Oficina privada',
            'descripcion' => 'Oficina cerrada con acceso exclusivo, perfecta para equipos pequeños.'
        ]);

        // Espacios
        $espacio1 = Espacio::create([
            'tipo_espacio_id' => $escritorio->id,
            'nombre' => 'Escritorio A1',
            'capacidad' => 1,
            'precio_por_hora' => 5000.00,
            'piso' => 1,
            'activo' => true,
        ]);
        Comodidad::create(['espacio_id' => $espacio1->id, 'nombre' => 'WiFi de alta velocidad']);
        Comodidad::create(['espacio_id' => $espacio1->id, 'nombre' => 'Lámpara LED']);
        Comodidad::create(['espacio_id' => $espacio1->id, 'nombre' => 'Enchufe USB']);

        $espacio2 = Espacio::create([
            'tipo_espacio_id' => $escritorio->id,
            'nombre' => 'Escritorio B3',
            'capacidad' => 1,
            'precio_por_hora' => 5000.00,
            'piso' => 1,
            'activo' => true,
        ]);
        Comodidad::create(['espacio_id' => $espacio2->id, 'nombre' => 'WiFi de alta velocidad']);
        Comodidad::create(['espacio_id' => $espacio2->id, 'nombre' => 'Silla ergonómica']);

        $espacio3 = Espacio::create([
            'tipo_espacio_id' => $sala->id,
            'nombre' => 'Sala Las Palmas',
            'capacidad' => 6,
            'precio_por_hora' => 18000.00,
            'piso' => 2,
            'activo' => true,
        ]);
        Comodidad::create(['espacio_id' => $espacio3->id, 'nombre' => 'Proyector 4K']);
        Comodidad::create(['espacio_id' => $espacio3->id, 'nombre' => 'Pizarra de vidrio']);
        Comodidad::create(['espacio_id' => $espacio3->id, 'nombre' => 'Sistema de videoconferencia']);
        Comodidad::create(['espacio_id' => $espacio3->id, 'nombre' => 'WiFi']);

        $espacio4 = Espacio::create([
            'tipo_espacio_id' => $sala->id,
            'nombre' => 'Sala El Nogal',
            'capacidad' => 10,
            'precio_por_hora' => 25000.00,
            'piso' => 2,
            'activo' => true,
        ]);
        Comodidad::create(['espacio_id' => $espacio4->id, 'nombre' => 'Pantalla interactiva']);
        Comodidad::create(['espacio_id' => $espacio4->id, 'nombre' => 'Cafetera Nespresso']);
        Comodidad::create(['espacio_id' => $espacio4->id, 'nombre' => 'Aire acondicionado independiente']);

        $espacio5 = Espacio::create([
            'tipo_espacio_id' => $oficina->id,
            'nombre' => 'Oficina 201',
            'capacidad' => 4,
            'precio_por_hora' => 35000.00,
            'piso' => 2,
            'activo' => true,
        ]);
        Comodidad::create(['espacio_id' => $espacio5->id, 'nombre' => 'Escritorios ejecutivos']);
        Comodidad::create(['espacio_id' => $espacio5->id, 'nombre' => 'Archivador']);
        Comodidad::create(['espacio_id' => $espacio5->id, 'nombre' => 'WiFi']);
        Comodidad::create(['espacio_id' => $espacio5->id, 'nombre' => 'TV 55"']);

        $espacio6 = Espacio::create([
            'tipo_espacio_id' => $oficina->id,
            'nombre' => 'Oficina 301 Premium',
            'capacidad' => 6,
            'precio_por_hora' => 50000.00,
            'piso' => 3,
            'activo' => true,
        ]);
        Comodidad::create(['espacio_id' => $espacio6->id, 'nombre' => 'Ventanal panorámico']);
        Comodidad::create(['espacio_id' => $espacio6->id, 'nombre' => 'Mini nevera']);
        Comodidad::create(['espacio_id' => $espacio6->id, 'nombre' => 'Impresora láser']);
        Comodidad::create(['espacio_id' => $espacio6->id, 'nombre' => 'WiFi premium']);

        // Usuarios de prueba
        User::create([
            'name' => 'María Camila Torres',
            'email' => 'admin@cowork.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'company' => 'CoworkSpot Central',
            'phone' => '3101112233',
        ]);

        User::create([
            'name' => 'Carlos Andrés Gómez',
            'email' => 'carlos.gomez@email.com',
            'password' => bcrypt('cliente123'),
            'role' => 'member',
            'company' => 'Diseños Gráficos S.A.S.',
            'phone' => '3205556677',
        ]);

        User::create([
            'name' => 'Laura Marcela Díaz',
            'email' => 'laura.diaz@startup.com',
            'password' => bcrypt('cliente123'),
            'role' => 'member',
            'company' => 'InnovApp Tech',
            'phone' => '3114443322',
        ]);
    }
}