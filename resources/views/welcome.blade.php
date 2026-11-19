<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistema de Regularización de Producto – Control de Calidad</title>
<style>
:root{--bg:#0f172a;--card:#1e293b;--line:#334155;--txt:#e2e8f0;--mut:#94a3b8;
--blue:#38bdf8;--green:#4ade80;--red:#f87171;--amber:#fbbf24;--violet:#a78bfa}
*{box-sizing:border-box;margin:0;padding:0;font-family:'Segoe UI',system-ui,sans-serif}
body{background:var(--bg);color:var(--txt);min-height:100vh}
.wrap{max-width:1450px;margin:auto;padding:14px}
#login{display:flex;align-items:center;justify-content:center;min-height:100vh;padding:16px}
.lbox{background:var(--card);border:1px solid var(--line);border-radius:16px;padding:28px;width:min(400px,94vw)}
.lbox h1{font-size:1.2rem;margin-bottom:4px}
.lbox p{color:var(--mut);font-size:.82rem;margin-bottom:16px}
label{font-size:.78rem;color:var(--mut);display:block;margin:10px 0 4px}
input,select,textarea{width:100%;padding:9px;border-radius:8px;border:1px solid var(--line);background:#0b1220;color:var(--txt);font-size:.88rem}
textarea{resize:vertical;min-height:60px}
button{cursor:pointer;border:none;border-radius:8px;padding:9px 13px;font-weight:700;font-size:.8rem;margin:4px 4px 0 0;transition:.15s}
button:hover{filter:brightness(1.18)}
button:disabled{opacity:.4;cursor:not-allowed}
.b-blue{background:var(--blue);color:#082f49}.b-green{background:var(--green);color:#052e16}
.b-amber{background:var(--amber);color:#451a03}.b-gray{background:var(--line);color:var(--txt)}
.b-red{background:var(--red);color:#450a0a}.b-violet{background:var(--violet);color:#2e1065}
.full{width:100%;margin-top:14px;padding:12px;font-size:.95rem}
.err{color:var(--red);font-size:.8rem;margin-top:8px;display:none}
#app{display:none}
header{display:flex;flex-wrap:wrap;gap:10px;align-items:center;justify-content:space-between;
background:var(--card);border:1px solid var(--line);border-radius:12px;padding:10px 14px;margin-bottom:12px}
header h1{font-size:1.05rem}
.user{display:flex;align-items:center;gap:10px;font-size:.82rem}
.badge{background:#1e3a8a;border:1px solid var(--blue);border-radius:20px;padding:3px 12px;font-weight:700;font-size:.72rem}
.stats{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px}
.stat{background:var(--card);border:1px solid var(--line);border-radius:10px;padding:8px 12px;text-align:center;flex:1;min-width:92px}
.stat .n{font-size:1.35rem;font-weight:800;color:var(--blue)}
.stat .l{font-size:.62rem;color:var(--mut);text-transform:uppercase}
.grid{display:grid;grid-template-columns:340px 1fr;gap:12px}
@media(max-width:980px){.grid{grid-template-columns:1fr}}
.card{background:var(--card);border:1px solid var(--line);border-radius:12px;padding:13px;margin-bottom:12px}
.card h2{font-size:.82rem;color:var(--blue);margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px}
.lock{opacity:.45;pointer-events:none;position:relative}
.lockmsg{font-size:.72rem;color:var(--amber);margin-top:6px}
.chk{display:flex;align-items:center;gap:8px;margin:8px 0;font-size:.84rem}
.chk input{width:auto}
.board{display:grid;grid-template-columns:repeat(4,1fr);gap:8px}
@media(max-width:1200px){.board{grid-template-columns:repeat(2,1fr)}}
.col{background:#0b1220;border:1px solid var(--line);border-radius:10px;padding:7px;min-height:110px}
.col h3{font-size:.66rem;text-align:center;padding:5px;border-radius:6px;margin-bottom:7px}
.c1 h3{background:#7f1d1d}.c2 h3{background:#78350f}.c3 h3{background:#1e3a8a}.c4 h3{background:#14532d}
.ticket{background:var(--card);border:1px solid var(--line);border-left:4px solid var(--blue);
border-radius:8px;padding:7px;margin-bottom:7px;font-size:.73rem}
.ticket.urg{border-left-color:var(--red);box-shadow:0 0 7px rgba(248,113,113,.25)}
.tag{display:inline-block;padding:1px 7px;border-radius:20px;font-size:.6rem;font-weight:700;margin:2px 2px 0 0}
.t-ret{background:#7f1d1d}.t-opt{background:#14532d}.t-urg{background:var(--red);color:#450a0a}.t-loc{background:var(--line)}
.ticket button{padding:5px 8px;font-size:.66rem;width:100%;margin-top:5px}
.panel{max-height:220px;overflow-y:auto;font-size:.72rem}
.logrow{padding:4px 6px;border-bottom:1px solid #24314a;display:flex;gap:7px}
.logrow .tm{color:var(--mut);min-width:110px}
.logrow .ac{color:var(--amber);min-width:100px;font-weight:600}
.notif{padding:6px 8px;border-radius:8px;background:#0b1220;margin-bottom:5px;border-left:3px solid var(--violet)}
.notif.mia{border-left-color:var(--green);background:#0d1f14}
.gav{height:12px;background:#0b1220;border-radius:6px;overflow:hidden;margin-top:5px;border:1px solid var(--line)}
.gav div{height:100%;background:var(--green);transition:.4s}
.gav.full div{background:var(--red)}
.modal-bg{display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:50;align-items:center;justify-content:center}
.modal{background:var(--card);border:1px solid var(--blue);border-radius:14px;padding:20px;width:min(500px,94vw);max-height:90vh;overflow-y:auto}
.modal h2{color:var(--amber);font-size:1rem;margin-bottom:4px}
.modal .paso{color:var(--mut);font-size:.75rem;margin-bottom:10px}
.opts{display:grid;gap:7px;margin:10px 0}
.opt{background:#0b1220;border:2px solid var(--line);border-radius:10px;padding:11px;cursor:pointer;font-size:.85rem;text-align:left;color:var(--txt);width:100%;margin:0}
.opt:hover{border-color:var(--blue);background:#16233c}
.opt small{display:block;color:var(--mut);font-size:.7rem;margin-top:2px}
.sn{display:flex;gap:8px;margin:12px 0}
.sn button{flex:1;padding:12px;font-size:.9rem}
#toast{position:fixed;bottom:16px;right:16px;z-index:99;max-width:330px}
.toast{background:#0b1220;border:1px solid var(--violet);border-left:4px solid var(--violet);
border-radius:10px;padding:10px 13px;margin-top:7px;font-size:.78rem;animation:tin .3s}
@keyframes tin{from{transform:translateX(80px);opacity:0}to{transform:none;opacity:1}}
.pulse{animation:pul 1.2s infinite}
@keyframes pul{0%,100%{box-shadow:0 0 0 0 rgba(251,191,36,.5)}50%{box-shadow:0 0 0 7px rgba(251,191,36,0)}}
.tabs{display:flex;gap:6px;margin-bottom:10px;flex-wrap:wrap}
.tab{background:#0b1220;border:1px solid var(--line);color:var(--mut);border-radius:8px;padding:7px 12px;font-size:.75rem}
.tab.on{background:#1e3a8a;color:var(--txt);border-color:var(--blue)}
table{width:100%;border-collapse:collapse;font-size:.72rem}
th,td{padding:5px 7px;border-bottom:1px solid #24314a;text-align:left}
th{color:var(--blue);font-size:.68rem;text-transform:uppercase}
.filtros{display:flex;gap:8px;margin-bottom:8px;flex-wrap:wrap}
.filtros input,.filtros select{width:auto;flex:1;min-width:130px}
small.hint{color:var(--mut);font-size:.7rem;display:block;margin-top:4px}
</style>
</head>
<body>

<div id="login">
 <div class="lbox">
  <h1>🏭 Sistema de Regularización de Producto</h1>
  <p>Control de Calidad · Acceso por área de trabajo</p>
  <label>Usuario</label><input id="lu" placeholder="usuario" autocomplete="username">
  <label>Contraseña</label><input id="lp" type="password" placeholder="••••••••" autocomplete="current-password" onkeydown="if(event.key==='Enter')entrar()">
  <button class="b-blue full" onclick="entrar()">🔐 Ingresar</button>
  <div class="err" id="lerr">Usuario o contraseña incorrectos.</div>
  <small class="hint">Cuentas iniciales: <b>etiquetado / cc / verificacion / admin</b> — contraseña inicial: <b>1234</b>. El administrador puede crear usuarios y cambiar contraseñas.</small>
 </div>
</div>

<div id="app"><div class="wrap">
<header>
 <h1>🏭 Regularización de Producto · Control de Calidad</h1>
 <div class="user">
  <span>👤 <b id="uNom"></b></span><span class="badge" id="uRol"></span>
  <button class="b-gray" onclick="salir()">Cerrar sesión</button>
 </div>
</header>

<div class="stats">
 <div class="stat"><div class="n" id="sTotal">0</div><div class="l">Productos</div></div>
 <div class="stat"><div class="n" id="sRet">0</div><div class="l">Retenidos</div></div>
 <div class="stat"><div class="n" id="sCola">0</div><div class="l">En cola</div></div>
 <div class="stat"><div class="n" id="sListo">0</div><div class="l">Por perchar</div></div>
 <div class="stat"><div class="n" id="sComp">0</div><div class="l">Compras</div></div>
 <div class="stat"><div class="n" id="sRep">0</div><div class="l">Reportes</div></div>
</div>

<div class="grid">
<div>
 <div class="card" id="cardEtiq">
  <h2>🏷️ Etiquetado · Registrar producto NO óptimo</h2>
  <label>Código / SKU del producto *</label><input id="pSku" placeholder="Ej: SKU-1045">
  <label>Nombre del producto *</label><input id="pNom" placeholder="Ej: Silla de oficina">
  <label>Cantidad</label><input id="pCant" type="number" min="1" value="1">
  <label>Observación (opcional)</label><textarea id="pObs" placeholder="Detalle del daño detectado..."></textarea>
  <div class="chk"><input type="checkbox" id="pUrg"><span>⚡ Requiere restauración URGENTE</span></div>
  <label>Gavetas ocupadas: <b id="gavN">0</b>/<b id="gavCap">5</b></label>
  <div class="gav" id="gavBar"><div style="width:0%"></div></div>
  <button class="b-blue" onclick="detectar()">🔎 Registrar detección</button>
  <div class="lockmsg" id="lockEtiq" style="display:none">🔒 Solo el área de Etiquetado (o admin) puede registrar detecciones.</div>
 </div>

 <div class="card" id="cardVerif">
  <h2>🔍 Verificación · Revisión por turnos</h2>
  <button class="b-amber" id="btnRev" onclick="revisar()">📋 Revisar siguiente en cola</button>
  <small class="hint">Atiende la cola FIFO; los ⚡urgentes se atienden primero.</small>
  <div class="lockmsg" id="lockVerif" style="display:none">🔒 Solo el área de Verificación (o admin) puede revisar.</div>
 </div>

 <div class="card" id="cardCC">
  <h2>✅ Control de Calidad · Regularización</h2>
  <button class="b-green" id="btnReg" onclick="regularizar()">🔄 Regularizar siguiente</button>
  <small class="hint">Finaliza el flujo y traslada a zona Producto por Perchar.</small>
  <div class="lockmsg" id="lockCC" style="display:none">🔒 Solo Control de Calidad (o admin) puede regularizar.</div>
 </div>

 <div class="card" id="cardAdmin" style="display:none">
  <h2>⚙️ Administración</h2>
  <label>Capacidad de gavetas</label><input id="aCap" type="number" min="1">
  <button class="b-blue" onclick="setCap()">Guardar capacidad</button>
  <hr style="border-color:var(--line);margin:12px 0">
  <label>Nuevo usuario</label><input id="nuUser" placeholder="usuario">
  <label>Nombre completo</label><input id="nuNom" placeholder="Nombre y apellido">
  <label>Rol</label><select id="nuRol"><option value="ETIQUETADO">Etiquetado</option><option value="VERIFICACION">Verificación</option><option value="CC">Control de Calidad</option><option value="ADMIN">Administrador</option></select>
  <label>Contraseña</label><input id="nuPass" type="password" placeholder="contraseña">
  <button class="b-green" onclick="crearUsuario()">➕ Crear usuario</button>
  <div class="panel" id="listaUsers" style="margin-top:10px"></div>
  <hr style="border-color:var(--line);margin:12px 0">
  <button class="b-violet" onclick="exportar()">💾 Exportar respaldo (JSON)</button>
  <button class="b-violet" onclick="$('impFile').click()">📂 Importar respaldo</button>
  <input type="file" id="impFile" accept=".json" style="display:none" onchange="importar(this)">
  <button class="b-red" onclick="reiniciar()">🗑 Reiniciar datos</button>
 </div>

 <div class="card">
  <h2>🛒 Compras / ⚠️ Reportes</h2>
  <div class="panel" id="extras"><i style="color:var(--mut)">Sin solicitudes ni reportes.</i></div>
 </div>
</div>

<div>
 <div class="card">
  <h2>📊 Tablero del proceso</h2>
  <div class="board">
   <div class="col c1"><h3>🔴 DETECTADO / EN CC</h3><div id="colA"></div></div>
   <div class="col c2"><h3>🟠 REVISIÓN / RETENIDO</h3><div id="colB"></div></div>
   <div class="col c3"><h3>🔵 COLA REGULARIZACIÓN</h3><div id="colC"></div></div>
   <div class="col c4"><h3>🟢 PRODUCTO POR PERCHAR</h3><div id="colD"></div></div>
  </div>
 </div>

 <div class="card">
  <div class="tabs">
   <button class="tab on" id="tab1" onclick="verTab(1)">🔔 Notificaciones</button>
   <button class="tab" id="tab2" onclick="verTab(2)">🗂 Bitácora</button>
   <button class="tab" id="tab3" onclick="verTab(3)">📦 Inventario</button>
  </div>
  <div id="vista1"><div class="panel" id="notifs" style="max-height:280px"><i style="color:var(--mut)">Aún no hay notificaciones.</i></div></div>
  <div id="vista2" style="display:none">
   <button class="b-gray" onclick="exportarCSV()">⬇ Descargar bitácora CSV</button>
   <div class="panel" id="log" style="max-height:280px;margin-top:8px"></div>
  </div>
  <div id="vista3" style="display:none">
   <div class="filtros">
    <input id="fBuscar" placeholder="🔎 Buscar código o nombre..." oninput="render()">
    <select id="fFase" onchange="render()"><option value="">Todas las fases</option><option value="DETECTADO">Detectado</option><option value="COLA_REV">Cola revisión</option><option value="RETENIDO_ZONA">Zona retenido</option><option value="REPORTADO">Reportado</option><option value="COLA_REG">Cola regularización</option><option value="LISTO">Por perchar</option></select>
    <button class="b-gray" onclick="exportarInvCSV()">⬇ CSV</button>
   </div>
   <div class="panel" style="max-height:280px"><table id="tablaInv"></table></div>
  </div>
 </div>
</div>
</div>

<div class="modal-bg" id="modalBg"><div class="modal" id="modalBox"></div></div>
<div id="toast"></div>
</div></div>
<script>
/* ============================================================
   SISTEMA DE REGULARIZACIÓN DE PRODUCTO — versión de producción
   Datos guardados en el navegador (localStorage). Sin internet.
   ============================================================ */
var DB_KEY='sistema_cc_v1';
var DB=null, SESION=null, enRevision=null;

function $(id){return document.getElementById(id)}
function ahora(){var d=new Date();return d.toLocaleDateString('es-EC')+' '+d.toLocaleTimeString('es-EC',{hour12:false})}
function esc(t){return String(t==null?'':t).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;')}

/* ---------- PERSISTENCIA ---------- */
function cargar(){
  try{var raw=localStorage.getItem(DB_KEY); if(raw){DB=JSON.parse(raw);return}}catch(e){}
  DB={usuarios:[
      {u:'admin',n:'Administrador',r:'ADMIN',p:'1234'},
      {u:'etiquetado',n:'Operador Etiquetado',r:'ETIQUETADO',p:'1234'},
      {u:'verificacion',n:'Inspector Verificación',r:'VERIFICACION',p:'1234'},
      {u:'cc',n:'Analista Control de Calidad',r:'CC',p:'1234'}],
     productos:{},colaRev:[],colaReg:[],bitacora:[],notifs:[],compras:[],reportes:[],
     gavetas:0,cap:5,seq:0};
  guardar();
}
function guardar(){try{localStorage.setItem(DB_KEY,JSON.stringify(DB))}catch(e){alert('No se pudo guardar en este navegador. Use Exportar respaldo con frecuencia.')}}

/* ---------- SESIÓN Y ROLES ---------- */
function entrar(){
  var u=$('lu').value.trim().toLowerCase(), p=$('lp').value;
  var user=DB.usuarios.filter(function(x){return x.u===u&&x.p===p})[0];
  if(!user){$('lerr').style.display='block';return}
  SESION=user; $('lerr').style.display='none';
  $('login').style.display='none'; $('app').style.display='block';
  $('uNom').textContent=user.n; $('uRol').textContent=user.r;
  log('-','SISTEMA','Inicio de sesión: '+user.n+' ('+user.r+')');
  aplicarPermisos(); render();
}
function salir(){
  log('-','SISTEMA','Cierre de sesión: '+SESION.n);
  SESION=null; $('app').style.display='none'; $('login').style.display='flex';
  $('lu').value=''; $('lp').value='';
}
function puede(rol){return SESION&&(SESION.r===rol||SESION.r==='ADMIN')}
function aplicarPermisos(){
  $('cardEtiq').className='card'+(puede('ETIQUETADO')?'':' lock');
  $('lockEtiq').style.display=puede('ETIQUETADO')?'none':'block';
  $('cardVerif').className='card'+(puede('VERIFICACION')?'':' lock');
  $('lockVerif').style.display=puede('VERIFICACION')?'none':'block';
  $('cardCC').className='card'+(puede('CC')?'':' lock');
  $('lockCC').style.display=puede('CC')?'none':'block';
  $('cardAdmin').style.display=puede('ADMIN')?'block':'none';
  if(puede('ADMIN')){$('aCap').value=DB.cap; listarUsuarios()}
}

/* ---------- BITÁCORA Y NOTIFICACIONES ---------- */
function log(pid,actor,accion){
  DB.bitacora.unshift({t:ahora(),pid:pid,actor:actor,acc:accion,user:SESION?SESION.n:'—'});
  if(DB.bitacora.length>3000)DB.bitacora.length=3000;
  guardar();
}
function notif(dest,msg){
  DB.notifs.unshift({t:ahora(),dest:dest,msg:msg});
  if(DB.notifs.length>500)DB.notifs.length=500;
  log('-','SISTEMA','Notificación a '+dest+': '+msg);
  if(SESION&&(dest===SESION.r||SESION.r==='ADMIN'||dest==='TODOS')){
    var t=document.createElement('div');t.className='toast';
    t.innerHTML='🔔 <b>'+esc(dest)+'</b>: '+esc(msg);
    $('toast').appendChild(t);setTimeout(function(){t.remove()},5000);
  }
  guardar();
}
function estado(p,n){log(p.sku,'SISTEMA','Estado: '+p.estado+' → '+n);p.estado=n}
function ubic(p,n){log(p.sku,'SISTEMA','Ubicación: '+p.ubicacion+' → '+n);p.ubicacion=n}
function encolar(cola,p){if(p.urgente)cola.unshift(p.sku);else cola.push(p.sku)}

/* ================= FASE 1 · ETIQUETADO ================= */
function detectar(){
  if(!puede('ETIQUETADO')){alert('Su rol no permite registrar detecciones.');return}
  var sku=$('pSku').value.trim().toUpperCase(), nom=$('pNom').value.trim();
  var cant=parseInt($('pCant').value)||1;
  if(!sku||!nom){alert('Complete el código (SKU) y el nombre del producto.');return}
  if(DB.productos[sku]){alert('El código '+sku+' ya está registrado en el sistema.');return}
  if(cant<1){alert('La cantidad debe ser al menos 1.');return}
  var p={sku:sku,nombre:nom,cant:cant,obs:$('pObs').value.trim(),estado:'OPTIMO',
         ubicacion:'GAVETAS',urgente:$('pUrg').checked,fase:'DETECTADO',problema:'',
         creado:ahora(),por:SESION.n};
  DB.productos[sku]=p;
  $('pSku').value='';$('pNom').value='';$('pCant').value=1;$('pObs').value='';$('pUrg').checked=false;
  log(sku,'ETIQUETADO','Reconocimiento de producto NO óptimo (x'+cant+')');
  DB.gavetas++;
  if(DB.gavetas>DB.cap){
    notif('CC','Gavetas saturadas → traslado automático de '+sku+' a CC');
    trasladarCC(sku);
  }else{
    ubic(p,'ALMAC. TEMPORAL ETIQUETADO');
    if(p.urgente)restauracionInmediata(p);
    else notif('CC',sku+' no óptimo en almacenamiento temporal de Etiquetado');
  }
  guardar(); render();
}
function trasladarCC(sku){
  if(!puede('ETIQUETADO')&&!puede('CC')){alert('Su rol no permite traslados a CC.');return}
  var p=DB.productos[sku];
  if(p.fase!=='DETECTADO'){render();return}
  ubic(p,'CC'); DB.gavetas=Math.max(0,DB.gavetas-1);
  log(sku,'ETIQUETADO','Traslado de mercadería a CC · cambio de ubicación');
  if(p.urgente)restauracionInmediata(p);
  else ccRecibe(p);
  guardar(); render();
}
function restauracionInmediata(p){
  estado(p,'RETENIDO');
  log(p.sku,'ETIQUETADO','Restauración inmediata (producto urgente)');
  notif('VERIFICACION','Entrega de '+p.sku+' para consolidación de producto');
  estado(p,'OPTIMO'); p.fase='LISTO'; ubic(p,'PRODUCTO POR PERCHAR');
  log(p.sku,'SISTEMA','Flujo finalizado (urgente)');
}
/* ================= FASE 2 · CC RECIBE ================= */
function ccRecibe(p){
  estado(p,'RETENIDO');
  ubic(p,'ALMAC. TEMPORAL CC'); p.fase='COLA_REV';
  notif('VERIFICACION',p.sku+' retenido → cola de revisión');
  encolar(DB.colaRev,p);
}
/* ================= FASE 3 · VERIFICACIÓN ================= */
function revisar(){
  if(!puede('VERIFICACION')){alert('Su rol no permite revisar productos.');return}
  if(!DB.colaRev.length){alert('No hay productos en cola de revisión.');return}
  enRevision=DB.colaRev.shift();
  var p=DB.productos[enRevision]; p.fase='REVISION';
  log(p.sku,'VERIFICACION','Identificación y revisión del producto');
  guardar(); pasoTipo(); render();
}
function modal(html){$('modalBox').innerHTML=html;$('modalBg').style.display='flex'}
function cerrar(){$('modalBg').style.display='none'}
function volverACola(){
  var p=DB.productos[enRevision]; p.fase='COLA_REV'; encolar(DB.colaRev,p);
  enRevision=null; cerrar(); guardar(); render();
}
function infoProd(p){
  return '<div class="paso">'+esc(p.nombre)+' · cantidad: '+p.cant+(p.obs?'<br>Obs: '+esc(p.obs):'')+'</div>';
}
function pasoTipo(){
  var p=DB.productos[enRevision];
  modal('<h2>🔍 Revisión de '+esc(p.sku)+'</h2>'+infoProd(p)+
  '<div class="paso">Seleccione el tipo de problema encontrado:</div><div class="opts">'+
  '<button class="opt" onclick="elegir(\'EMPAQUE\')">📦 Problema de empaque<small>Notifica a Etiquetado → registro CC → regularización</small></button>'+
  '<button class="opt" onclick="elegir(\'ESTETICO\')">🎨 Problema estético<small>Propuesta de restauración → autorización de CC</small></button>'+
  '<button class="opt" onclick="elegir(\'MECANICO\')">⚙️ Problema mecánico<small>Validación con Importaciones / corrección</small></button>'+
  '<button class="opt" onclick="elegir(\'NINGUNO\')">✅ Producto inconsistente: NO (detección errónea)<small>Notifica a Verificación y regulariza</small></button>'+
  '</div><button class="b-gray" onclick="volverACola()">↩ Devolver a la cola</button>');
}
function elegir(tipo){
  var p=DB.productos[enRevision]; p.problema=tipo;
  log(p.sku,'VERIFICACION','Clasificación del problema: '+tipo);
  if(tipo==='EMPAQUE')rutaEmpaque(p);
  else if(tipo==='ESTETICO')pasoBodega(p);
  else if(tipo==='MECANICO')pasoDudas(p);
  else rutaDeteccionErronea(p);
}
function rutaDeteccionErronea(p){
  notif('VERIFICACION','Notificación de detección errónea: '+p.sku+' se encuentra en buen estado');
  estado(p,'OPTIMO'); cerrar(); aRegularizacion(p); render();
}
function rutaEmpaque(p){
  notif('ETIQUETADO',p.sku+': problema de empaque → traslado a Etiquetado');
  ubic(p,'ETIQUETADO');
  log(p.sku,'CC','Registro de CC');
  estado(p,'OPTIMO');
  cerrar(); aRegularizacion(p); render();
}
/* Ruta ESTÉTICO */
function pasoBodega(p){
  modal('<h2>🎨 '+esc(p.sku)+' · Problema estético</h2>'+
  '<div class="paso">Evaluación de Verificación:</div>'+
  '<p style="margin:8px 0"><b>¿Se puede restaurar en bodega?</b></p>'+
  '<div class="sn"><button class="b-green" onclick="pasoAutoriza()">✔ SÍ</button>'+
  '<button class="b-gray" onclick="noRestaurable()">✖ NO</button></div>');
}
function pasoAutoriza(){
  var p=DB.productos[enRevision];
  log(p.sku,'VERIFICACION','Propuesta de Restauración enviada a CC');
  modal('<h2>🎨 '+esc(p.sku)+' · Propuesta de restauración</h2>'+
  '<div class="paso">Decisión de Control de Calidad:</div>'+
  '<p style="margin:8px 0"><b>¿Se autoriza la restauración?</b></p>'+
  '<div class="sn"><button class="b-green" onclick="pasoInsumos()">✔ SÍ, autorizar</button>'+
  '<button class="b-gray" onclick="noRestaurable()">✖ NO autorizar</button></div>');
}
function pasoInsumos(){
  var p=DB.productos[enRevision];
  log(p.sku,'CC','Restauración autorizada');
  modal('<h2>🎨 '+esc(p.sku)+' · Restauración autorizada</h2>'+
  '<div class="paso">Verificación de recursos:</div>'+
  '<p style="margin:8px 0"><b>¿Requiere adquisición de insumos?</b></p>'+
  '<div class="sn"><button class="b-amber" onclick="finEstetico(true)">🛒 SÍ → Compras</button>'+
  '<button class="b-green" onclick="finEstetico(false)">✔ NO, restaurar</button></div>');
}
function finEstetico(insumos){
  var p=DB.productos[enRevision];
  if(insumos){DB.compras.push({sku:p.sku,t:ahora(),estado:'PENDIENTE'});
    notif('TODOS','Gestión de Compras: adquirir insumos para '+p.sku)}
  log(p.sku,'ETIQUETADO','Restauración ejecutada');
  estado(p,'OPTIMO'); cerrar(); aRegularizacion(p); render();
}
function noRestaurable(){
  var p=DB.productos[enRevision];
  log(p.sku,'VERIFICACION','No restaurable / no autorizado → zona Producto Retenido');
  ubic(p,'ZONA PRODUCTO RETENIDO'); p.fase='RETENIDO_ZONA';
  cerrar(); enRevision=null; guardar(); render();
}
/* Ruta MECÁNICO */
function pasoDudas(p){
  modal('<h2>⚙️ '+esc(p.sku)+' · Problema mecánico</h2>'+
  '<div class="paso">Evaluación técnica:</div>'+
  '<p style="margin:8px 0"><b>¿Existen dudas del funcionamiento mecánico del producto?</b></p>'+
  '<div class="sn"><button class="b-amber" onclick="validarImport(true)">✔ SÍ → Importaciones</button>'+
  '<button class="b-blue" onclick="validarImport(false)">✖ NO</button></div>');
}
function validarImport(dudas){
  var p=DB.productos[enRevision];
  if(dudas){
    notif('TODOS','Validar con Importaciones el funcionamiento mecánico de '+p.sku);
    log(p.sku,'VERIFICACION','Información validada con Importaciones');
  }
  modal('<h2>⚙️ '+esc(p.sku)+' · Evaluación final</h2>'+
  '<div class="paso">Decisión de Verificación:</div>'+
  '<p style="margin:8px 0"><b>¿Requiere corrección?</b><br><small style="color:var(--mut)">SÍ = se corrige y regulariza · NO = se genera reporte</small></p>'+
  '<div class="sn"><button class="b-green" onclick="finMecanico(true)">✔ SÍ, corregir</button>'+
  '<button class="b-gray" onclick="finMecanico(false)">✖ NO → Reporte</button></div>');
}
function finMecanico(corregir){
  var p=DB.productos[enRevision];
  if(corregir){
    log(p.sku,'VERIFICACION','Corrección mecánica aplicada');
    estado(p,'OPTIMO'); cerrar(); aRegularizacion(p);
  }else{
    DB.reportes.push({sku:p.sku,t:ahora(),motivo:'Falla mecánica — requiere evaluación'});
    notif('VERIFICACION','Reporte generado por falla mecánica de '+p.sku);
    ubic(p,'ZONA PRODUCTO RETENIDO'); p.fase='REPORTADO';
    cerrar(); enRevision=null;
  }
  guardar(); render();
}
/* ================= REGULARIZACIÓN ================= */
function aRegularizacion(p){
  enRevision=null;
  if(p.urgente){
    log(p.sku,'CC','Producto urgente → regularización directa');
    p.fase='LISTO'; ubic(p,'PRODUCTO POR PERCHAR');
    log(p.sku,'SISTEMA','Flujo finalizado');
  }else{
    p.fase='COLA_REG'; encolar(DB.colaReg,p);
    notif('CC',p.sku+' listo → cola de regularización');
  }
  guardar();
}
function regularizar(){
  if(!puede('CC')){alert('Su rol no permite regularizar productos.');return}
  if(!DB.colaReg.length){alert('No hay productos en cola de regularización.');return}
  var p=DB.productos[DB.colaReg.shift()];
  log(p.sku,'CC','Regularización de producto');
  p.fase='LISTO'; ubic(p,'PRODUCTO POR PERCHAR');
  log(p.sku,'SISTEMA','Flujo finalizado');
  guardar(); render();
}
/* ================= INTERFAZ ================= */
function verTab(n){
  for(var i=1;i<=3;i++){$('vista'+i).style.display=(i===n)?'block':'none';
    $('tab'+i).className='tab'+(i===n?' on':'')}
}
function ticket(p,extra){
  return '<div class="ticket'+(p.urgente?' urg':'')+'"><b>'+esc(p.sku)+'</b> · '+esc(p.nombre)+' <span style="color:var(--mut)">x'+p.cant+'</span><br>'+
  '<span class="tag '+(p.estado==='RETENIDO'?'t-ret':'t-opt')+'">'+p.estado+'</span>'+
  (p.urgente?'<span class="tag t-urg">⚡URGENTE</span>':'')+
  (p.problema?'<span class="tag t-loc">'+esc(p.problema)+'</span>':'')+'<br>'+
  '<span class="tag t-loc">📍'+esc(p.ubicacion)+'</span>'+(extra||'')+'</div>';
}
function render(){
  var A=[],B=[],C=[],D=[];
  for(var k in DB.productos){var p=DB.productos[k];
    if(p.fase==='DETECTADO')A.push(p);
    else if(p.fase==='COLA_REV'||p.fase==='REVISION'||p.fase==='RETENIDO_ZONA'||p.fase==='REPORTADO')B.push(p);
    else if(p.fase==='COLA_REG')C.push(p);
    else D.push(p)}
  var puedeTras=puede('ETIQUETADO')||puede('CC');
  $('colA').innerHTML=A.map(function(p){return ticket(p,puedeTras?'<button class="b-blue" onclick="trasladarCC(\''+p.sku+'\')">📦 Trasladar a CC</button>':'')}).join('')||'<i style="color:var(--mut);font-size:.7rem">vacío</i>';
  $('colB').innerHTML=B.map(function(p){return ticket(p,p.fase==='COLA_REV'?'<span class="tag t-loc">⏳ turno '+(DB.colaRev.indexOf(p.sku)+1)+'</span>':'')}).join('')||'<i style="color:var(--mut);font-size:.7rem">vacío</i>';
  $('colC').innerHTML=C.map(function(p){return ticket(p,'<span class="tag t-loc">⏳ turno '+(DB.colaReg.indexOf(p.sku)+1)+'</span>')}).join('')||'<i style="color:var(--mut);font-size:.7rem">vacío</i>';
  $('colD').innerHTML=D.map(function(p){return ticket(p)}).join('')||'<i style="color:var(--mut);font-size:.7rem">vacío</i>';
  $('log').innerHTML=DB.bitacora.map(function(l){return '<div class="logrow"><span class="tm">'+l.t+'</span><span class="ac">'+esc(l.actor)+'</span><span>['+esc(l.pid)+'] '+esc(l.acc)+' · <i>'+esc(l.user)+'</i></span></div>'}).join('')||'<i style="color:var(--mut)">Sin registros.</i>';
  $('notifs').innerHTML=DB.notifs.map(function(n){
    var mia=SESION&&(n.dest===SESION.r||n.dest==='TODOS');
    return '<div class="notif'+(mia?' mia':'')+'"><b>'+esc(n.dest)+'</b> · '+n.t+'<br>'+esc(n.msg)+'</div>'}).join('')||'<i style="color:var(--mut)">Aún no hay notificaciones.</i>';
  var ex=DB.compras.map(function(c){return '🛒 Insumos para <b>'+esc(c.sku)+'</b> · '+c.t+' · '+c.estado+
      (puede('CC')&&c.estado==='PENDIENTE'?' <button class="b-green" style="padding:3px 8px;font-size:.65rem" onclick="recibirInsumo(\''+c.sku+'\')">✔ Recibido</button>':'')})
    .concat(DB.reportes.map(function(r){return '⚠️ <b>'+esc(r.sku)+'</b> · '+r.t+'<br>'+esc(r.motivo)}));
  $('extras').innerHTML=ex.length?ex.map(function(e){return '<div class="notif">'+e+'</div>'}).join(''):'<i style="color:var(--mut)">Sin solicitudes ni reportes.</i>';
  $('sTotal').textContent=Object.keys(DB.productos).length;
  $('sRet').textContent=Object.keys(DB.productos).filter(function(k){return DB.productos[k].estado==='RETENIDO'}).length;
  $('sCola').textContent=DB.colaRev.length+DB.colaReg.length;
  $('sListo').textContent=D.length;
  $('sComp').textContent=DB.compras.filter(function(c){return c.estado==='PENDIENTE'}).length;
  $('sRep').textContent=DB.reportes.length;
  $('gavN').textContent=Math.min(DB.gavetas,DB.cap); $('gavCap').textContent=DB.cap;
  var bar=$('gavBar');bar.firstElementChild.style.width=Math.min(DB.gavetas/DB.cap*100,100)+'%';
  bar.className='gav'+(DB.gavetas>=DB.cap?' full':'');
  $('btnRev').className='b-amber'+(DB.colaRev.length&&puede('VERIFICACION')?' pulse':'');
  $('btnReg').className='b-green'+(DB.colaReg.length&&puede('CC')?' pulse':'');
  renderInv();
}
function renderInv(){
  var q=($('fBuscar').value||'').toLowerCase(), f=$('fFase').value;
  var filas=Object.keys(DB.productos).map(function(k){return DB.productos[k]})
    .filter(function(p){return (!q||p.sku.toLowerCase().indexOf(q)>=0||p.nombre.toLowerCase().indexOf(q)>=0)&&(!f||p.fase===f)})
    .sort(function(a,b){return a.creado<b.creado?1:-1});
  $('tablaInv').innerHTML='<tr><th>Código</th><th>Producto</th><th>Cant</th><th>Estado</th><th>Fase</th><th>Ubicación</th><th>Registrado</th></tr>'+
   filas.map(function(p){return '<tr><td><b>'+esc(p.sku)+'</b>'+(p.urgente?' ⚡':'')+'</td><td>'+esc(p.nombre)+'</td><td>'+p.cant+'</td><td>'+p.estado+'</td><td>'+p.fase+'</td><td>'+esc(p.ubicacion)+'</td><td>'+p.creado+'<br><i>'+esc(p.por)+'</i></td></tr>'}).join('');
}
function recibirInsumo(sku){
  DB.compras.forEach(function(c){if(c.sku===sku)c.estado='RECIBIDO'});
  log(sku,'CC','Insumos recibidos — compra cerrada');
  notif('ETIQUETADO','Insumos disponibles para '+sku);
  guardar(); render();
}
/* ================= ADMINISTRACIÓN ================= */
function setCap(){
  var v=parseInt($('aCap').value);
  if(!v||v<1){alert('Capacidad inválida.');return}
  DB.cap=v; log('-','ADMIN','Capacidad de gavetas cambiada a '+v); guardar(); render();
}
function crearUsuario(){
  var u=$('nuUser').value.trim().toLowerCase(), n=$('nuNom').value.trim(),
      r=$('nuRol').value, p=$('nuPass').value;
  if(!u||!n||!p){alert('Complete usuario, nombre y contraseña.');return}
  if(DB.usuarios.some(function(x){return x.u===u})){alert('Ese usuario ya existe.');return}
  DB.usuarios.push({u:u,n:n,r:r,p:p});
  log('-','ADMIN','Usuario creado: '+u+' ('+r+')');
  $('nuUser').value='';$('nuNom').value='';$('nuPass').value='';
  guardar(); listarUsuarios();
}
function listarUsuarios(){
  $('listaUsers').innerHTML=DB.usuarios.map(function(x){
    return '<div class="notif"><b>'+esc(x.u)+'</b> · '+esc(x.n)+' · '+x.r+
    ' <button class="b-gray" style="padding:3px 8px;font-size:.65rem" onclick="resetPass(\''+x.u+'\')">🔑 Clave</button>'+
    (x.u!=='admin'?' <button class="b-red" style="padding:3px 8px;font-size:.65rem" onclick="borrarUser(\''+x.u+'\')">✖</button>':'')+'</div>'}).join('');
}
function resetPass(u){
  var np=prompt('Nueva contraseña para '+u+':'); if(!np)return;
  DB.usuarios.forEach(function(x){if(x.u===u)x.p=np});
  log('-','ADMIN','Contraseña restablecida: '+u); guardar(); alert('Contraseña actualizada.');
}
function borrarUser(u){
  if(!confirm('¿Eliminar el usuario '+u+'?'))return;
  DB.usuarios=DB.usuarios.filter(function(x){return x.u!==u});
  log('-','ADMIN','Usuario eliminado: '+u); guardar(); listarUsuarios();
}
function reiniciar(){
  if(!confirm('Esto borra TODOS los productos, colas y bitácora (los usuarios se conservan). ¿Continuar?'))return;
  if(!confirm('Confirmación final: ¿reiniciar los datos del proceso?'))return;
  var us=DB.usuarios, cap=DB.cap;
  localStorage.removeItem(DB_KEY); cargar(); DB.usuarios=us; DB.cap=cap;
  log('-','ADMIN','Datos del proceso reiniciados'); guardar(); aplicarPermisos(); render();
}
/* ================= RESPALDOS Y EXPORTACIÓN ================= */
function descargar(nombre,contenido,tipo){
  var a=document.createElement('a');
  a.href=URL.createObjectURL(new Blob([contenido],{type:tipo}));
  a.download=nombre; a.click(); URL.revokeObjectURL(a.href);
}
function exportar(){
  descargar('respaldo_cc_'+new Date().toISOString().slice(0,10)+'.json',JSON.stringify(DB,null,1),'application/json');
  log('-','ADMIN','Respaldo JSON exportado'); render();
}
function importar(inp){
  var f=inp.files[0]; if(!f)return;
  var r=new FileReader();
  r.onload=function(){
    try{var d=JSON.parse(r.result);
      if(!d.productos||!d.usuarios)throw 0;
      if(!confirm('¿Reemplazar todos los datos actuales con el respaldo?'))return;
      DB=d; guardar(); SESION=null;
      $('app').style.display='none';$('login').style.display='flex';
      alert('Respaldo importado. Inicie sesión nuevamente.');
    }catch(e){alert('Archivo de respaldo inválido.')}
  };
  r.readAsText(f); inp.value='';
}
function csvCell(t){return '"'+String(t==null?'':t).replace(/"/g,'""')+'"'}
function exportarCSV(){
  var l=['Fecha;Actor;Producto;Accion;Usuario'].concat(DB.bitacora.map(function(x){
    return [x.t,x.actor,x.pid,x.acc,x.user].map(csvCell).join(';')}));
  descargar('bitacora_cc.csv','\ufeff'+l.join('\n'),'text/csv');
}
function exportarInvCSV(){
  var l=['Codigo;Producto;Cantidad;Estado;Fase;Ubicacion;Urgente;Problema;Registrado;Por'].concat(
    Object.keys(DB.productos).map(function(k){var p=DB.productos[k];
      return [p.sku,p.nombre,p.cant,p.estado,p.fase,p.ubicacion,p.urgente?'SI':'NO',p.problema,p.creado,p.por].map(csvCell).join(';')}));
  descargar('inventario_cc.csv','\ufeff'+l.join('\n'),'text/csv');
}
/* ================= ARRANQUE ================= */
cargar();
window.addEventListener('beforeunload',function(){guardar()});
</script>
</body>
</html>