# EcoEventos

Una aplicación web integral para la gestión de eventos comunitarios sostenibles, desarrollada en PHP puro con almacenamiento en archivos CSV. Permite a los usuarios crear, gestionar, inscribirse y registrar el impacto de eventos ecológicos.

<img src="https://github.com/user-attachments/assets/010cfaab-26f2-4502-8f53-d938596349ed" 
     width="600" height="400" alt="image" 
     style="display: block; margin: 0 auto;" />

## Descripción

EcoEventos es una plataforma digital diseñada para simplificar y optimizar la organización, promoción y participación en eventos comunitarios con un enfoque en la sostenibilidad. Facilita la conexión entre organizadores y participantes, permitiendo la planificación de actividades, gestión de inscripciones, difusión de información relevante y el seguimiento del impacto ambiental y social de cada evento.

## Características Principales

- **Gestión Completa de Eventos**: Creación, visualización, edición y filtrado de eventos ecológicos (Limpieza, Sembratón, Minga).
- **Sistema de Usuarios**: Registro y autenticación (login/logout).
- **Inscripciones de Participantes**: Registro sencillo a eventos con control de cupos y listado de inscritos.
- **Registro de Impacto Ambiental**: Herramientas para que los organizadores registren métricas de sostenibilidad (plástico, metal, papel/cartón, otros residuos, árboles plantados).
- **Estadísticas Detalladas**: Visualización de datos estadísticos de asistencia y participación en eventos, incluyendo porcentajes de asistencia.
- **API RESTful**: Conjunto de endpoints para la interacción programática con la aplicación (creación, lectura, actualización de eventos, inscripciones, impacto).
- **Interfaz de Usuario Moderna y Responsiva**: Diseño intuitivo y adaptable a diferentes dispositivos (ordenadores, tablets, smartphones).
  
## Tecnologías Utilizadas

- **Backend**: PHP 8.1 (o superior) con una arquitectura basada en el patrón Modelo-Vista-Controlador (MVC).
- **Almacenamiento**: Archivos CSV para la persistencia de datos (eventos, usuarios, inscripciones, impactos).
- **Frontend**: HTML5, CSS3 (con estilos modernos y responsivos), y JavaScript ES6+ para interactividad.
- **Servidor**: PHP Built-in Server (para desarrollo y pruebas).

## Estructura del Proyecto

```
EcoEventos/
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

## Uso de la Aplicación

1.  **Registro e Inicio de Sesión**: Regístrate como nuevo usuario o inicia sesión con una cuenta existente para acceder a todas las funcionalidades.
2.  **Explorar Eventos**: En la página principal, puedes ver todos los eventos disponibles. Utiliza la barra de búsqueda y los filtros por tipo para encontrar eventos específicos.
3.  **Crear un Evento**: Si has iniciado sesión, haz clic en "+ Crear Evento" para publicar una nueva actividad sostenible. Completa los detalles como título, tipo, fecha, ubicación, cupo y descripción.
4.  **Ver Detalles del Evento**: Haz clic en cualquier tarjeta de evento para ver su información completa, incluyendo detalles adicionales y la lista de participantes inscritos.
5.  **Inscribirse a un Evento**: Desde la página de detalles de un evento, puedes inscribirte. Tu nombre y email se rellenarán automáticamente si has iniciado sesión.
6.  **Editar Eventos y Registrar Impacto**: Si eres el organizador de un evento, verás botones para "Editar" el evento o "Registrar Impacto" en su página de detalles. Aquí podrás actualizar la información del evento o añadir métricas de sostenibilidad (ej. cantidad de residuos reciclados, árboles plantados).
7.  **Ver Estadísticas**: Accede a la sección "Estadísticas" desde la barra de navegación para ver un resumen de todos los eventos, el total de inscritos y el promedio de asistencia, junto con una tabla detallada por evento.
8.  **Mis Eventos**: En la sección "Mis eventos" (disponible para usuarios logueados), podrás ver los eventos que has organizado.

## Estructura de Datos (Archivos CSV)

### `events.csv`
Almacena la información de cada evento.
```csv
id,titulo,tipo,fecha,hora,ubicacion,cupo,inscritos,descripcion,detalle,organizer_id
```

### `users.csv`
Contiene los datos de los usuarios registrados.
```csv
id,nombre,email,password_hash
```

### `registrations.csv`
Registra las inscripciones de los usuarios a los eventos.
```csv
id,event_id,nombre,email,timestamp
```

### `impacts.csv`
Guarda las métricas de impacto ambiental registradas para cada evento.
```csv
id,event_id,organizer_id,plastico,metal,papel_carton,otros,arboles,timestamp,notas
```

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

## Contribuciones

Para preguntas, sugerencias o contribuciones, por favor crea un issue o un pull request en el repositorio del proyecto.




