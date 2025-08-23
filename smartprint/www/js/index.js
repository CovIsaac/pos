var app = {
  apiBase: localStorage.getItem('apiBase') || 'http://192.168.1.100:8000/api',
  printerIP: localStorage.getItem('printerIP') || '192.168.1.50',
  printerPort: parseInt(localStorage.getItem('printerPort') || '9100', 10),
  lastId: 0,
  timer: null,
  running: false,

  initialize: function () {
    document.addEventListener('deviceready', this.onDeviceReady.bind(this), false);
    document.addEventListener('DOMContentLoaded', () => {
      const api = document.getElementById('api');
      const ip  = document.getElementById('ip');
      const port= document.getElementById('port');
      const btnSave = document.getElementById('save');
      const btnTest = document.getElementById('test');
      const btnToggle = document.getElementById('toggle');

      this.lastId = parseInt(localStorage.getItem('lastId') || '0', 10);

      api.value  = this.apiBase;
      ip.value   = this.printerIP;
      port.value = String(this.printerPort);

      btnSave.addEventListener('click', () => {
        this.apiBase    = api.value.trim().replace(/\/+$/,'');
        this.printerIP  = ip.value.trim();
        this.printerPort= parseInt(port.value, 10) || 9100;
        localStorage.setItem('apiBase', this.apiBase);
        localStorage.setItem('printerIP', this.printerIP);
        localStorage.setItem('printerPort', String(this.printerPort));
        alert('Guardado ✅');
      });

      btnTest.addEventListener('click', async () => {
        try {
          await this.printToTcp(this.sampleTicket());
          alert('Ticket de prueba enviado ✅');
        } catch (e) {
          alert('Error al imprimir: ' + e.message);
        }
      });

      btnToggle.textContent = this.running ? 'Detener servicio' : 'Iniciar servicio';
      btnToggle.addEventListener('click', () => {
        if (this.running) {
          this.stopService();
          btnToggle.textContent = 'Iniciar servicio';
        } else {
          this.startService();
          btnToggle.textContent = 'Detener servicio';
        }
      });
    });
  },

  onDeviceReady: function () {
    if (cordova.plugins.backgroundMode) {
      cordova.plugins.backgroundMode.setDefaults({ title: 'SmartPrint', text: 'Escuchando pedidos…' });
    }
    if (window.plugins && window.plugins.autostart) {
      window.plugins.autostart.enable();
    }
  },

  startService() {
    if (this.running) return;
    if (cordova.plugins.backgroundMode) {
      cordova.plugins.backgroundMode.enable();
      if (cordova.plugins.backgroundMode.disableBatteryOptimizations) {
        cordova.plugins.backgroundMode.disableBatteryOptimizations();
      }
    }
    this.timer = setInterval(this.checkAndPrint.bind(this), 3000);
    this.running = true;
  },

  stopService() {
    if (!this.running) return;
    clearInterval(this.timer);
    this.timer = null;
    if (cordova.plugins.backgroundMode) {
      cordova.plugins.backgroundMode.disable();
    }
    this.running = false;
  },

  // ====== POS API ======
  async fetchJobs() {
    try {
      const url = `${this.apiBase}/print-jobs?after_id=${this.lastId}`;
      const resp = await fetch(url, { headers: { "Accept": "application/json" }});
      if (!resp.ok) return [];
      return await resp.json();
    } catch (e) {
      console.error('fetchJobs', e);
      return [];
    }
  },

  async checkAndPrint() {
    const jobs = await this.fetchJobs();
    for (const job of jobs) {
      try {
        const bytes = this.buildEscPos(job);
        await this.printToTcp(bytes);
        await fetch(`${this.apiBase}/print-jobs/${job.id}/done`, { method: 'POST' });
        this.lastId = Math.max(this.lastId, job.id);
        localStorage.setItem('lastId', String(this.lastId));
      } catch (e) {
        console.error('print job error', e);
      }
    }
  },

  // ====== ESC/POS Helpers ======
  encLatin1(str){
    try { return new TextEncoder('latin1').encode(str); }
    catch { return new Uint8Array([...str].map(ch => ch.charCodeAt(0) & 0xFF)); }
  },

  buildEscPos(pedido) {
    const ESC = Uint8Array.from([0x1B]);
    const GS  = Uint8Array.from([0x1D]);
    const out = [];
    const bytes = this.encLatin1.bind(this);
    const cmd = arr => Uint8Array.from(arr);

    out.push(ESC, this.encLatin1("@"));                  // init
    out.push(ESC, this.encLatin1("a"), cmd([1]));        // center
    out.push(bytes("SMARTBAR\n"));
    out.push(ESC, this.encLatin1("a"), cmd([0]));        // left
    out.push(bytes(`Folio: ${pedido.folio || '-'}\n`));
    out.push(bytes(`Mesa: ${pedido.mesa || '-'}\n`));
    out.push(bytes("------------------------------\n"));

    (pedido.items || []).forEach(i => {
      out.push(bytes(`${i.qty} x ${i.name}  $${Number(i.price).toFixed(2)}\n`));
      if (i.notes) out.push(bytes(`  * ${i.notes}\n`));
    });

    out.push(bytes("------------------------------\n"));
    out.push(bytes(`TOTAL: $${Number(pedido.total||0).toFixed(2)}\n\n\n`));
    out.push(GS, this.encLatin1("V"), cmd([66, 0]));     // corte parcial

    const total = out.reduce((a,u)=>a+u.length,0);
    const res = new Uint8Array(total);
    let off = 0;
    out.forEach(u=>{ res.set(u,off); off+=u.length; });
    return res;
  },

  sampleTicket() {
    return this.buildEscPos({
      folio: "PRUEBA-001",
      mesa: "12",
      items: [
        { qty: 2, name: "Aperol Spritz", price: 70 },
        { qty: 1, name: "Margarita",     price: 80, notes: "Sin sal" }
      ],
      total: 220
    });
  },

  // ====== TCP a impresora ======
  async printToTcp(bytes) {
    return new Promise((resolve, reject) => {
      if (!window.chrome || !chrome.sockets || !chrome.sockets.tcp) {
        return reject(new Error('Plugin TCP no disponible'));
      }
      chrome.sockets.tcp.create({}, createInfo => {
        const socketId = createInfo.socketId;
        chrome.sockets.tcp.connect(socketId, this.printerIP, this.printerPort, result => {
          if (result < 0) {
            chrome.sockets.tcp.close(socketId);
            return reject(new Error('No conecta a '+this.printerIP+':'+this.printerPort));
          }
          chrome.sockets.tcp.send(socketId, bytes.buffer, sendInfo => {
            chrome.sockets.tcp.close(socketId);
            if (sendInfo.resultCode < 0) return reject(new Error('Error al enviar datos'));
            resolve(true);
          });
        });
      });
    });
  }
};

app.initialize();
