<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar Compra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="checkoutForm" action="{{ route('ventas.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          {{-- Selección de tipo de entrega --}}
          <div id="seleccionEntrega">
            <h6>¿Cómo deseas recibir tu pedido?</h6>
            <div class="d-flex gap-3 my-3">
              <button type="button" class="btn btn-outline-primary flex-fill" id="btnRecojo">Recojo en tienda</button>
              <button type="button" class="btn btn-outline-primary flex-fill" id="btnEnvio">Envío a domicilio</button>
            </div>
          </div>

          {{-- Tipo entrega --}}
          <input type="hidden" name="tipo_entrega" id="tipoEntregaInput">

          <div id="formContenido" style="display:none;">
            <div id="formEnvioCampos" style="display:none;">
              <h6>Envío a domicilio <small class="text-muted">(Costo adicional aplicará)</small></h6>

              <div class="mb-3">
                <label for="direccionEnvio" class="form-label">Dirección de envío</label>
                <textarea class="form-control" id="direccionEnvio" name="direccion_envio" rows="2"></textarea>
              </div>

              {{-- Mapa --}}
              <div class="mb-3">
                <label class="form-label">Ubicación en el mapa</label>
                <div id="mapaCheckout" style="height: 300px; border: 1px solid #ccc;"></div>
                <input type="hidden" name="latitud" id="latitud">
                <input type="hidden" name="longitud" id="longitud">
              </div>
            </div>

            {{-- Teléfono de contacto --}}
            <div class="mb-3">
              <label for="telefonoContacto" class="form-label">Número de contacto</label>
              <input type="text" class="form-control" id="telefonoContacto" name="telefono_contacto" required>
            </div>

            {{-- QR --}}
            <div class="mb-3 text-center">
              <p>Escanea el código QR para realizar el pago:</p>
              <img src="{{ asset('images/qr.jpg') }}" alt="Código QR" style="max-width: 200px;" class="rounded shadow">
            </div>

            {{-- Comprobante --}}
            <div class="mb-3">
              <label for="comprobantePago" class="form-label">Subir comprobante de pago (imagen o PDF)</label>
              <input type="file" class="form-control" id="comprobantePago" name="comprobante_pago" accept="image/*,application/pdf" required>
            </div>

            <button type="submit" class="btn btn-impacto btn-lg w-100">Enviar Pedido</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts del Checkout -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const btnRecojo = document.getElementById('btnRecojo');
  const btnEnvio = document.getElementById('btnEnvio');
  const formContenido = document.getElementById('formContenido');
  const formEnvioCampos = document.getElementById('formEnvioCampos');
  const tipoEntregaInput = document.getElementById('tipoEntregaInput');
  const checkoutForm = document.getElementById('checkoutForm');

  // Botón Recojo
  btnRecojo.addEventListener('click', () => {
    formContenido.style.display = 'block';
    formEnvioCampos.style.display = 'none';
    tipoEntregaInput.value = 'recojo';
    document.getElementById('direccionEnvio').removeAttribute('required');
  });

  // Botón Envío
  btnEnvio.addEventListener('click', () => {
    formContenido.style.display = 'block';
    formEnvioCampos.style.display = 'block';
    tipoEntregaInput.value = 'envio';
    document.getElementById('direccionEnvio').setAttribute('required', 'required');

    if (typeof inicializarMapaCheckout === 'function') {
      setTimeout(() => {
        inicializarMapaCheckout();
      }, 300);
    }
  });

  // Enviar formulario por AJAX
  if (checkoutForm) {
    checkoutForm.addEventListener('submit', async function (e) {
      e.preventDefault();

      const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');

      if (carrito.length === 0) {
        mostrarToast("🛒 Tu carrito está vacío.", true);
        return;
      }

      const formData = new FormData(this);

      // ✅ Agregar productos al FormData de forma correcta
      carrito.forEach((item, index) => {
        formData.append(`productos[${index}][id]`, item.id);
        formData.append(`productos[${index}][cantidad]`, item.cantidad);
      });

      try {
        const response = await fetch(this.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
        });

        const text = await response.text();
        let data;

        try {
          data = JSON.parse(text);
        } catch (jsonError) {
          console.error("❌ No se pudo parsear respuesta JSON:", jsonError, text);
          mostrarToast("❌ Error inesperado del servidor", true);
          return;
        }

        console.log("📥 Respuesta del servidor:", data);

        if (response.ok && data.success) {
  localStorage.removeItem('carrito');
  actualizarContadorCarrito();

  const modal = bootstrap.Modal.getInstance(document.getElementById('checkoutModal'));
  if (modal) modal.hide();

  mostrarToast(data.message || "✅ Tu pedido fue enviado exitosamente.", false);
} else {
  const mensajeError = data.error
    ? `${data.message}: ${data.error}`
    : data.message || "❌ Ocurrió un error al procesar tu pedido.";

  console.error("⚠️ Error en respuesta:", data);
  mostrarToast(mensajeError, true);
}


      } catch (error) {
        console.error("⚠️ Error de red o servidor:", error);
        mostrarToast("⚠️ Error al conectar con el servidor", true);
      }
    });
  }
});
</script>


<!-- Mapa Leaflet -->
<script>
let mapa, marcador;

function inicializarMapaCheckout() {
  if (mapa) {
    mapa.invalidateSize();
    return;
  }

  mapa = L.map('mapaCheckout').setView([-17.7833, -63.1821], 13); // Santa Cruz por defecto

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap',
    maxZoom: 18,
  }).addTo(mapa);

  // Geolocalización
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        mapa.setView([lat, lng], 15);
        marcador = L.marker([lat, lng]).addTo(mapa);
        document.getElementById('latitud').value = lat.toFixed(7);
        document.getElementById('longitud').value = lng.toFixed(7);
      },
      (error) => {
        console.warn('No se pudo obtener ubicación:', error.message);
      }
    );
  }

  // Clic en mapa
  mapa.on('click', function (e) {
    const { lat, lng } = e.latlng;

    if (marcador) {
      marcador.setLatLng(e.latlng);
    } else {
      marcador = L.marker(e.latlng).addTo(mapa);
    }

    document.getElementById('latitud').value = lat.toFixed(7);
    document.getElementById('longitud').value = lng.toFixed(7);
  });
}
</script>

