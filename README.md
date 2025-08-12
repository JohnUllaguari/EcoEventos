# 
# EcoEventos

Una aplicación web para la gestión de eventos ecológicos desarrollada en PHP con almacenamiento en archivos CSV.
<img width="600" height="400" alt="image" src="https://github.com/user-attachments/assets/edeef75e-b7df-44c4-873f-820674081b1c" />

## Descripción

EcoEventos es una plataforma simple y eficiente para crear, gestionar e inscribirse a eventos relacionados con actividades ecológicas como limpiezas, sembratons y mingas comunitarias.

## Características

- **Gestión de Eventos**: Crear, visualizar y filtrar eventos ecológicos
- **Inscripciones**: Sistema de registro para participantes con control de cupos
- **Tipos de Eventos**: Soporte para diferentes categorías (Limpieza, Sembratón, Minga)
- **Búsqueda y Filtros**: Buscar eventos por título, descripción o ubicación
- **API REST**: Endpoints para integración con otras aplicaciones

## Tecnologías

- **Backend**: PHP 8.2
- **Almacenamiento**: Archivos CSV
- **Frontend**: HTML, CSS vanilla
- **Servidor**: PHP Built-in Server

## Estructura del Proyecto

```
├── app/
│   ├── controllers/
│   │   └── EventController.php     # Controlador principal de eventos
│   ├── models/
│   │   ├── EventModel.php          # Modelo de eventos
│   │   └── RegistrationModel.php   # Modelo de inscripciones
│   ├── views/
│   │   ├── events/                 # Vistas de eventos
│   │   └── layout/                 # Plantillas base
│   └── helpers.php                 # Funciones auxiliares
├── data/
│   ├── events.csv                  # Datos de eventos
│   └── registrations.csv           # Datos de inscripciones
└── public/
    └── index.php                   # Front controller
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
   php -S localhost:8000 -t public
   ```
4. Visita `http://localhost:8000` en tu navegador

## Uso

### Funcionalidades Principales

1. **Ver Eventos**: Navega a la página principal para ver todos los eventos disponibles
2. **Filtrar Eventos**: Usa los filtros por tipo y búsqueda de texto
3. **Crear Evento**: Haz clic en "Crear Evento" y completa el formulario
4. **Ver Detalles**: Haz clic en cualquier evento para ver información detallada
5. **Inscribirse**: En la página de detalles, completa el formulario de inscripción

### Campos de Evento

- **Título**: Nombre del evento (obligatorio)
- **Tipo**: Categoría del evento (Limpieza, Sembratón, Minga)
- **Fecha**: Fecha del evento (obligatorio)
- **Hora**: Hora de inicio (opcional)
- **Ubicación**: Lugar donde se realizará (obligatorio)
- **Cupo**: Número máximo de participantes (0 = ilimitado)
- **Descripción**: Descripción breve del evento
- **Detalle**: Información adicional detallada

## Estructura de Datos

### Eventos (events.csv)
```csv
id,titulo,tipo,fecha,hora,ubicacion,cupo,inscritos,descripcion,detalle
```

### Inscripciones (registrations.csv)
```csv
id,event_id,nombre,email,timestamp
```


Para preguntas o sugerencias sobre el proyecto, por favor crea un issue en el repositorio.
