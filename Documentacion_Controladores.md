# Documentación de los Controladores de ServicioTech

¡Hola! Aquí tienes la explicación sencilla de los 4 controladores principales del proyecto. Un controlador básicamente es el "cerebro" que recibe lo que el usuario pide (como hacer clic en un botón) y decide qué datos buscar en la base de datos y qué pantalla (HTML/vista) mostrarle.

---

## 1. AuthController (Login y Registro)
**¿Para qué sirve?** 
Este archivo se encarga de todo lo relacionado con las cuentas: iniciar sesión, registrar nuevos usuarios y cerrar sesión.

**Modelos con los que se relaciona:** `Usuario`, `Cliente`, `Rol`.

**Métodos principales:**
* `mostrarLogin()`: No recibe parámetros. Revisa si el usuario ya está conectado; si no lo está, le muestra la pantalla para poner su correo y contraseña. Retorna la vista `auth.login`.
* `login(Request $request)`: Recibe los datos del formulario de login. Revisa que el correo y contraseña sean correctos. Si fallas 3 veces, bloquea la cuenta. Retorna una redirección al panel del usuario si entra bien, o mensajes de error si se equivoca.
* `mostrarRegistro()`: No recibe parámetros. Muestra el formulario para crear una cuenta nueva. Retorna la vista `auth.registro`.
* `registro(Request $request)`: Recibe los datos del formulario de registro (nombre, correo, contraseña). Guarda los datos en la tabla `usuarios` y en la tabla `clientes` (por defecto todos los nuevos son clientes). Luego inicia la sesión automáticamente y retorna al panel del cliente.
* `logout(Request $request)`: Cierra la sesión activa y limpia la memoria temporal del navegador. Retorna a la página de login.
* `redirigirSegunRol()`: (Método interno/privado) Revisa si el usuario es "admin", "tecnico" o "cliente" y retorna la ruta a su pantalla correcta para que un cliente no termine en la pantalla del jefe.

---

## 2. ClienteController (Panel de Clientes)
**¿Para qué sirve?** 
Es la zona exclusiva para los clientes. Aquí pueden ver sus electrodomésticos, pedir que les reparen algo y ver si el técnico ya va en camino.

**Modelos con los que se relaciona:** `Cliente`, `Electrodomestico`, `Solicitud`, `CategoriaFalla`, `Cita`.

**Métodos principales:**
* `dashboard()`: Prepara el resumen principal. Cuenta cuántos equipos y solicitudes tiene el cliente. Retorna la vista `cliente.dashboard` con estos números.
* `misEquipos()`: Busca todos los aparatos (neveras, lavadoras, etc.) registrados por este cliente. Retorna la vista `cliente.equipos.index`.
* `crearEquipo()` / `guardarEquipo(Request $request)`: El primero muestra el formulario para añadir un electrodoméstico. El segundo recibe los datos, los valida (que tenga tipo y marca) y los guarda en la base de datos.
* `solicitarServicio()` / `guardarSolicitud(Request $request)`: El primero muestra el formulario para pedir una reparación. El segundo toma la falla y el equipo elegido, y crea un ticket o "solicitud" con estado "pendiente".
* `misSolicitudes()`: Busca todo el historial de reparaciones que ha pedido el cliente.
* `verSolicitud($id)`: Recibe el ID de una solicitud y muestra todo el detalle (fotos, técnico asignado). Por seguridad, verifica que ese ID realmente le pertenezca a este cliente.
* `misCitas()`: Busca las fechas programadas en las que un técnico irá a su casa. Retorna la vista `cliente.citas.index`.

---

## 3. AdminController (Panel del Jefe/Admin)
**¿Para qué sirve?** 
Es el panel de control total. El administrador puede ver todo lo que pasa en el negocio, qué piden los clientes y ordenarles a los técnicos qué hacer.

**Modelos con los que se relaciona:** `Solicitud`, `Usuario`, `Tecnico`, `Cliente`, `Asignacion`, `Cita`.

**Métodos principales:**
* `dashboard()`: Saca las cuentas totales de la empresa (cuántos clientes hay, cuántos trabajos pendientes, qué técnicos están libres). Retorna la vista del dashboard del jefe.
* `solicitudes(Request $request)`: Muestra absolutamente todas las solicitudes de todos los clientes. Recibe parámetros opcionales por si el jefe quiere usar filtros (ej: ver solo las terminadas).
* `verSolicitud($id)`: Muestra a fondo una solicitud específica para que el jefe la revise.
* `asignarTecnico(Request $request, $id)`: Recibe el ID de un técnico y el de una solicitud. Une al técnico con el trabajo (crea una `Asignacion`) y quita a cualquier otro técnico que estuviera antes.
* `agendarCita(Request $request, $id)`: Recibe una fecha, una hora y el técnico. Guarda esto en la agenda para que el técnico vaya a la casa del cliente.
* `actualizarEstado(Request $request, $id)`: Permite al jefe cambiar el estado de un trabajo a la fuerza (ejemplo: cancelarlo).
* `usuarios()` / `cambiarDisponibilidad(Request $request, $id)`: Muestra a todo el personal. Permite cambiar a un técnico de "disponible" a "inactivo" (por ejemplo, si se enfermó o se fue de vacaciones).

---

## 4. TecnicoController (Panel de Técnicos)
**¿Para qué sirve?** 
Es la herramienta de trabajo de los reparadores. Aquí ven qué trabajos les asignó el jefe, actualizan si ya terminaron y suben fotos del aparato arreglado.

**Modelos con los que se relaciona:** `Asignacion`, `Solicitud`, `Evidencia`, `Cita`.

**Métodos principales:**
* `dashboard()`: Le muestra al técnico un resumen de su día (cuántos trabajos le faltan y cuáles son sus citas de hoy).
* `misAsignaciones()`: Busca y lista todos los trabajos activos que el jefe le ha mandado a este técnico específico.
* `verSolicitud($id)`: Muestra el detalle del trabajo (dirección, problema). Por seguridad, revisa que este técnico sí tenga permiso para ver este trabajo.
* `actualizarEstado(Request $request, $id)`: Recibe la orden del técnico de cambiar el trabajo a "en proceso" (ya lo está reparando) o "completada" (ya terminó).
* `subirEvidencia(Request $request, $id)`: Recibe un archivo (foto/video) y un texto explicativo. Lo guarda en el servidor (`storage`) y lo vincula al trabajo para que el jefe y el cliente puedan verlo.
* `misCitas()`: Busca la agenda completa del técnico con las fechas futuras ordenadas para que sepa a dónde ir cada día. Retorna la vista `tecnico.citas.index`.
