# Casos de Prueba - Políticas de Seguridad

## 1. Pruebas de Hashing de Contraseñas

### CP-001: Verificación de contraseña hasheada
**Descripción:** Verificar que el sistema compara correctamente contraseñas hasheadas
**Precondiciones:** Usuario registrado con contraseña "Password123"
**Pasos:**
1. Intentar login con credenciales válidas
2. Verificar que Hash::check retorna true
3. Intentar login con contrenciales inválidas
4. Verificar que Hash::check retorna false

**Resultado Esperado:** Las contraseñas se comparan correctamente usando hash

### CP-002: Almacenamiento seguro de contraseñas
**Descripción:** Verificar que las contraseñas no se almacenan en texto plano
**Precondiciones:** Base de datos con usuarios registrados
**Pasos:**
1. Consultar directamente la base de datos
2. Verificar que la columna password contiene hashes
3. Confirmar que no hay contraseñas en texto plano

**Resultado Esperado:** Todas las contraseñas están hasheadas

## 2. Pruebas de Regeneración de Sesión

### CP-003: Regeneración de ID de sesión post-login
**Descripción:** Verificar que el ID de sesión cambia después del login exitoso
**Precondiciones:** Sesión no autenticada activa
**Pasos:**
1. Capturar el session_id antes del login
2. Realizar login exitoso
3. Capturar el session_id después del login
4. Comparar ambos session_id

**Resultado Esperado:** Los session_id deben ser diferentes

### CP-004: Regeneración de token CSRF
**Descripción:** Verificar que el token CSRF cambia después del login
**Precondiciones:** Token CSRF de sesión no autenticada
**Pasos:**
1. Capturar token CSRF antes del login
2. Realizar login exitoso
3. Capturar nuevo token CSRF
4. Comparar ambos tokens

**Resultado Esperado:** Los tokens CSRF deben ser diferentes

## 3. Pruebas de Rate Limiting

### CP-005: Bloqueo por intentos excesivos
**Descripción:** Verificar que el sistema bloquea después de 5 intentos fallidos
**Precondiciones:** Cuenta de prueba existente
**Pasos:**
1. Realizar 5 intentos de login fallidos
2. Intentar sexto login
3. Verificar que retorna error 429 (Too Many Requests)
4. Esperar tiempo de bloqueo
5. Verificar que permite intentos nuevamente

**Resultado Esperado:** Bloqueo después de 5 intentos fallidos

### CP-006: Reset de contador con login exitoso
**Descripción:** Verificar que el contador se resetea con login exitoso
**Precondiciones:** 3 intentos fallidos previos
**Pasos:**
1. Realizar login exitoso
2. Realizar 5 intentos fallidos consecutivos
3. Verificar que aplica bloqueo

**Resultado Esperado:** El contador se resetea después de login exitoso

## 4. Pruebas de Validación de Entrada

### CP-007: Prevención de SQL Injection
**Descripción:** Verificar que el sistema sanitiza entradas SQL
**Precondiciones:** Formulario de login accesible
**Pasos:**
1. Intentar login con: `admin' OR '1'='1`
2. Intentar login con: `"; DROP TABLE users; --`
3. Verificar que rechaza las entradas
4. Confirmar que no se ejecutan queries maliciosas

**Resultado Esperado:** Entradas maliciosas son rechazadas y sanitizadas

### CP-008: Validación de formato de email
**Descripción:** Verificar validación de formato de email
**Precondiciones:** Campo email en formulario de login
**Pasos:**
1. Intentar login con email inválido: `usuario`
2. Intentar login con email inválido: `usuario@`
3. Intentar login con email válido: `usuario@dominio.com`
4. Verificar respuestas del sistema

**Resultado Esperado:** Solo acepta emails con formato válido

## 5. Pruebas de Verificación de Estado de Usuario

### CP-009: Login con usuario inactivo
**Descripción:** Verificar que usuarios inactivos no pueden loguearse
**Precondiciones:** Usuario con estado "inactivo" en BD
**Pasos:**
1. Intentar login con usuario inactivo
2. Verificar que retorna error específico
3. Confirmar que no se crea sesión

**Resultado Esperado:** Bloqueo de login para usuarios inactivos

### CP-010: Login con usuario activo
**Descripción:** Verificar que usuarios activos pueden loguearse
**Precondiciones:** Usuario con estado "activo" en BD
**Pasos:**
1. Intentar login con usuario activo
2. Verificar que permite acceso
3. Confirmar creación de sesión

**Resultado Esperado:** Permite login para usuarios activos

## 6. Pruebas de Configuración de Sesión

### CP-011: Expiración de sesión al cerrar navegador
**Descripción:** Verificar que la sesión expira al cerrar navegador
**Precondiciones:** Sesión activa
**Pasos:**
1. Cerrar completamente el navegador
2. Reabrir navegador y acceder a página protegida
3. Verificar que requiere login nuevamente

**Resultado Esperado:** Sesión se cierra al cerrar navegador

### CP-012: Cookies HTTP Only y Secure
**Descripción:** Verificar configuración de cookies de sesión
**Precondiciones:** Sesión activa
**Pasos:**
1. Inspeccionar cookies en navegador
2. Verificar flag HttpOnly está activo
3. Verificar flag Secure está activo (en HTTPS)
4. Intentar acceder a cookie via JavaScript

**Resultado Esperado:** Cookies protegidas con HttpOnly y Secure

### CP-013: Expiración de sesión por tiempo
**Descripción:** Verificar que la sesión expira después de 4 horas
**Precondiciones:** Sesión activa
**Pasos:**
1. Establecer sesión
2. Simular paso de 4 horas y 1 minuto
3. Intentar acceder a recurso protegido
4. Verificar que requiere reautenticación

**Resultado Esperado:** Sesión expira después de 4 horas

## 7. Pruebas de Integración

### CP-014: Flujo completo de seguridad
**Descripción:** Verificar integración de todas las medidas de seguridad
**Precondiciones:** Usuario activo registrado
**Pasos:**
1. Realizar login exitoso
2. Verificar regeneración de sesión
3. Verificar token CSRF nuevo
4. Realizar acciones con sesión activa
5. Cerrar navegador y verificar expiración
6. Verificar que contador de intentos se reseteó

**Resultado Esperado:** Todas las medidas de seguridad funcionan integradamente

## Métricas de Prueba

- **Cobertura:** 100% de las políticas de seguridad
- **Tipo:** Funcionales y de seguridad
- **Entorno:** Testing y staging
- **Frecuencia:** En cada deployment y mensualmente
