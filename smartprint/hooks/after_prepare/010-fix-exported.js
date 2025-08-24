#!/usr/bin/env node
/**
 * Hook post-prepare para Cordova (Android):
 * - Añade android:exported="true" a los receivers del plugin Autostart que tengan intent-filter
 * - Soporta cordova-android 10+ y 14.x (ruta app/src/main/AndroidManifest.xml)
 * - Es idempotente (si ya lo tiene, no duplica)
 */
const fs = require('fs');
const path = require('path');

module.exports = function (ctx) {
  try {
    const projectRoot = ctx.opts.projectRoot || process.cwd();
    // Posibles rutas de Manifest según versión de cordova-android
    const candidates = [
      path.join(projectRoot, 'platforms', 'android', 'app', 'src', 'main', 'AndroidManifest.xml'),
      path.join(projectRoot, 'platforms', 'android', 'AndroidManifest.xml'),
    ];

    const manifestPath = candidates.find(p => fs.existsSync(p));
    if (!manifestPath) {
      console.log('[hook] Manifest no encontrado, ¿agregaste la plataforma android? (platforms/android)');
      return;
    }

    let xml = fs.readFileSync(manifestPath, 'utf8');

    // Asegura que exista el namespace android (por si algún merge lo quitó)
    if (!/xmlns:android="http:\/\/schemas\.android\.com\/apk\/res\/android"/.test(xml)) {
      xml = xml.replace(
        /<manifest([^>]*)>/,
        '<manifest$1 xmlns:android="http://schemas.android.com/apk/res/android">'
      );
    }

    // 1) Receivers específicos del plugin Autostart
    const autostartReceivers = [
      'com.tonikorin.cordova.plugin.autostart.BootCompletedReceiver',
      'com.tonikorin.cordova.plugin.autostart.UserPresentReceiver',
      'com.tonikorin.cordova.plugin.autostart.PackageReplacedReceiver',
    ];

    let touched = 0;

    autostartReceivers.forEach(name => {
      // match al tag receiver que tenga android:name="name"
      const re = new RegExp(
        `<receiver([^>]*?)android:name="${name}"([^>]*)>([\\s\\S]*?)<\\/receiver>`,
        'g'
      );
      xml = xml.replace(re, (full, pre, post, inner) => {
        // Solo forzamos exported si **existe** un intent-filter (Android 12+ lo exige en componentes con intent-filter)
        const hasIntentFilter = /<\s*intent-filter[\s>]/.test(inner);
        const hasExported = /android:exported=/.test(full);
        if (hasIntentFilter && !hasExported) {
          touched++;
          return `<receiver${pre}android:name="${name}" android:exported="true"${post}>${inner}</receiver>`;
        }
        return full; // sin cambios
      });
    });

    // 2) Fallback: por si el plugin cambia nombres, aplica a cualquier receiver del paquete com.tonikorin... que tenga intent-filter
    // (No tocará los ya arreglados)
    const genericRe = /<receiver([^>]*?)android:name="(com\.tonikorin\.cordova\.plugin\.autostart\.[^"]+)"([^>]*)>([\s\S]*?)<\/receiver>/g;
    xml = xml.replace(genericRe, (full, pre, name, post, inner) => {
      const hasIntentFilter = /<\s*intent-filter[\s>]/.test(inner);
      const hasExported = /android:exported=/.test(full);
      if (hasIntentFilter && !hasExported) {
        touched++;
        return `<receiver${pre}android:name="${name}" android:exported="true"${post}>${inner}</receiver>`;
      }
      return full;
    });

    if (touched > 0) {
      fs.writeFileSync(manifestPath, xml, 'utf8');
      console.log(`[hook] android:exported aplicado a ${touched} receiver(s) del plugin Autostart`);
    } else {
      console.log('[hook] Nada que cambiar: receivers ya tenían android:exported o no tienen intent-filter');
    }
  } catch (err) {
    console.warn('[hook] Error corrigiendo android:exported:', err && err.message ? err.message : err);
  }
};
