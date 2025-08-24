# SmartPrint

## Compilación

1. Instala las dependencias:

   ```bash
   npm install
   ```

2. Agrega la plataforma Android (solo la primera vez):

   ```bash
   cordova platform add android
   ```

3. Compila el proyecto:

   ```bash
   cordova build
   ```

   También puedes ejecutar los dos últimos pasos de una sola vez con:

   ```bash
   npm run build
   ```

   Este script ejecuta `cordova platform add android` y `cordova build` en un solo paso.

