# EcoEventos

Una aplicación web para la gestión de eventos ecológicos desarrollada en PHP con almacenamiento en archivos CSV.
<img width="600" height="400" alt="image" src="https://github.com/user-attachments/assets/ffe0a3c7-1c8b-4342-932c-b860063c6d98" />

## Descripción

EcoEventos es una plataforma simple y eficiente para crear, gestionar e inscribirse a eventos relacionados con actividades ecológicas como limpiezas, sembratons y mingas comunitarias. La aplicación incluye un sistema de autenticación, seguimiento de impacto ambiental y una API REST completa.

## Características

- **Gestión de Eventos**: Crear, visualizar y filtrar eventos ecológicos
- **Sistema de Autenticación**: Registro e inicio de sesión de usuarios
- **Inscripciones**: Sistema de registro para participantes con control de cupos
- **Tipos de Eventos**: Soporte para diferentes categorías (Limpieza, Sembratón, Minga)
- **Búsqueda y Filtros**: Buscar eventos por título, descripción o ubicación
- **API REST**: Endpoints JSON para integración externa

## Tecnologías

- **Backend**: PHP 8.2
- **Almacenamiento**: Archivos CSV
- **Frontend**: HTML, CSS vanilla, JavaScript
- **Servidor**: PHP Built-in Server

## Estructura del Proyecto

```
├── app/
│   ├── controllers/
│   │   ├── EventController.php      # Controlador principal de eventos
│   │   ├── AuthController.php       # Controlador de autenticación
│   │   └── ImpactController.php     # Controlador de impacto ambiental
│   ├── models/
│   │   ├── EventModel.php           # Modelo de eventos
│   │   ├── RegistrationModel.php    # Modelo de inscripciones
│   │   ├── UserModel.php            # Modelo de usuarios
│   │   └── ImpactModel.php          # Modelo de impacto ambiental
│   ├── views/
│   │   ├── events/                  # Vistas de eventos
│   │   ├── auth/                    # Vistas de autenticación
│   │   ├── impact/                  # Vistas de impacto
│   │   └── layout/                  # Plantillas base
│   └── helpers.php                  # Funciones auxiliares
├── data/
│   ├── events.csv                   # Datos de eventos
│   ├── registrations.csv            # Datos de inscripciones
│   ├── users.csv                    # Datos de usuarios
│   └── impacts.csv                  # Datos de impacto ambiental
└── public/
    ├── assets/
    │   ├── css/
    │   │   └── site.css              # Estilos CSS
    │   └── js/
    │       └── app.js                # JavaScript del frontend
    └── index.php                     # Front controller
```

## Instalación y Configuración

### En Replit

1. El proyecto está configurado para ejecutarse automáticamente
2. Haz clic en el botón "Run" para iniciar el servidor
3. La aplicación estará disponible en el puerto 8000

### Instalación Local

1. Clona el repositorio
2. Asegúrate de tener PHP 8.2 o superior instalado
3. Ejecuta el servidor:
   ```bash
   php -S 0.0.0.0:8000 -t public
   ```
4. Visita `http://localhost:8000` en tu navegador

## Uso

### Funcionalidades Principales

1. **Registro e Inicio de Sesión**: Crea una cuenta o inicia sesión para acceder a todas las funcionalidades
2. **Ver Eventos**: Navega a la página principal para ver todos los eventos disponibles
3. **Filtrar Eventos**: Usa los filtros por tipo y búsqueda de texto
4. **Crear Evento**: Una vez autenticado, haz clic en "Crear Evento" y completa el formulario
5. **Ver Detalles**: Haz clic en cualquier evento para ver información detallada
6. **Inscribirse**: En la página de detalles, completa el formulario de inscripción
7. **Registrar Impacto**: Los organizadores pueden registrar el impacto ambiental de sus eventos

## API REST

La aplicación incluye una API REST completa con los siguientes endpoints:

### Eventos
- `GET /?action=api_events` - Listar eventos (con filtros opcionales)
- `GET /?action=api_event_detail&id={id}` - Detalle de un evento
- `POST /?action=api_event_create` - Crear evento (requiere autenticación)

### Inscripciones
- `POST /?action=api_register&id={event_id}` - Inscribirse a un evento

### Impacto Ambiental
- `GET /?action=api_impact_detail&id={event_id}` - Obtener impacto de un evento
- `POST /?action=api_impact_save&id={event_id}` - Guardar impacto (requiere autenticación)

### Ejemplo de uso con Postman

**Crear un evento:**
```
POST https://tu-repl-url.replit.dev/?action=api_event_create
Content-Type: application/json

{
  "titulo": "Limpieza del Parque Central",
  "tipo": "Limpieza",
  "fecha": "2024-02-15",
  "hora": "10:00",
  "ubicacion": "Parque Central",
  "cupo": 30,
  "descripcion": "Limpieza comunitaria del parque",
  "detalle": "Traer guantes y bolsas"
}
```

## Contribución

Para contribuir al proyecto:

1. Haz fork del repositorio
2. Crea una rama para tu funcionalidad
3. Realiza tus cambios
4. Envía un pull request

Para preguntas o sugerencias sobre el proyecto, por favor crea un issue en el repositorio.
