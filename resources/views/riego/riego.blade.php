@extends('layout')

@section('title', 'Control de Plagas - Lechuga')

@section('contenido')
<section class="page-section clearfix">
    <div class="container">
        <div class="card shadow rounded-lg">
            <div class="card-header bg-success text-white">
                <h2 class="text-center mb-0">Registro de Plagas en Cultivo de Lechuga</h2>
            </div>
            <div class="card-body">
                <form id="plagasForm" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Sección de Información Básica -->
                    <div class="mb-4">
                        <h4 class="text-success border-bottom pb-2">Información General</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha_deteccion" class="form-label">Fecha de Detección</label>
                                <input type="date" class="form-control" id="fecha_deteccion" name="fecha_deteccion" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="variedad_lechuga" class="form-label">Variedad de Lechuga</label>
                                <select class="form-select" id="variedad_lechuga" name="variedad_lechuga" required>
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="romana">Romana</option>
                                    <option value="iceberg">Iceberg</option>
                                    <option value="hoja_de_roble">Hoja de Roble</option>
                                    <option value="mantecosa">Mantecosa</option>
                                    <option value="otra">Otra</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="area_afectada" class="form-label">Área Afectada (m²)</label>
                            <input type="number" step="0.01" class="form-control" id="area_afectada" name="area_afectada" placeholder="Ej: 2.5" required>
                        </div>
                    </div>

                    <!-- Sección de Identificación de Plaga -->
                    <div class="mb-4">
                        <h4 class="text-success border-bottom pb-2">Identificación de Plaga</h4>
                        <div class="mb-3">
                            <label class="form-label">Tipo de Plaga (Seleccione todas las que apliquen)</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="plaga_pulgones" name="tipo_plaga[]" value="pulgones">
                                        <label class="form-check-label" for="plaga_pulgones">Pulgones</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="plaga_minador" name="tipo_plaga[]" value="minador">
                                        <label class="form-check-label" for="plaga_minador">Minador de la hoja</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="plaga_trips" name="tipo_plaga[]" value="trips">
                                        <label class="form-check-label" for="plaga_trips">Trips</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="plaga_escarabajo" name="tipo_plaga[]" value="escarabajo">
                                        <label class="form-check-label" for="plaga_escarabajo">Escarabajo</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="plaga_mosca_blanca" name="tipo_plaga[]" value="mosca_blanca">
                                        <label class="form-check-label" for="plaga_mosca_blanca">Mosca blanca</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="plaga_otra" name="tipo_plaga[]" value="otra">
                                        <label class="form-check-label" for="plaga_otra">Otra</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion_sintomas" class="form-label">Descripción de Síntomas/Daños Observados</label>
                            <textarea class="form-control" id="descripcion_sintomas" name="descripcion_sintomas" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="nivel_infestacion" class="form-label">Nivel de Infestación</label>
                            <select class="form-select" id="nivel_infestacion" name="nivel_infestacion" required>
                                <option value="" selected disabled>Seleccione...</option>
                                <option value="bajo">Bajo (pocos individuos)</option>
                                <option value="medio">Medio (daños visibles)</option>
                                <option value="alto">Alto (daños severos)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Sección de Manejo y Tratamiento -->
                    <div class="mb-4">
                        <h4 class="text-success border-bottom pb-2">Manejo y Tratamiento</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tratamiento_aplicado" class="form-label">Tratamiento Aplicado</label>
                                <select class="form-select" id="tratamiento_aplicado" name="tratamiento_aplicado" required>
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="quimico">Control Químico</option>
                                    <option value="biologico">Control Biológico</option>
                                    <option value="cultural">Control Cultural</option>
                                    <option value="fisico">Control Físico</option>
                                    <option value="ninguno">Ninguno aún</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="producto_utilizado" class="form-label">Producto Utilizado</label>
                                <input type="text" class="form-control" id="producto_utilizado" name="producto_utilizado" placeholder="Nombre del producto">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones/Recomendaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
                        </div>
                    </div>

                    <!-- Sección de Imágenes -->
                    <div class="mb-4">
                        <h4 class="text-success border-bottom pb-2">Evidencia Fotográfica</h4>
                        <div class="mb-3">
                            <label for="foto_plaga" class="form-label">Subir Foto de la Plaga/Daño</label>
                            <input class="form-control" type="file" id="foto_plaga" name="foto_plaga" accept="image/*" required>
                            <small class="text-muted">Formatos aceptados: JPG, PNG. Tamaño máximo: 5MB</small>
                        </div>
                        <div class="mb-3">
                            <label for="foto_tratamiento" class="form-label">Subir Foto del Tratamiento (opcional)</label>
                            <input class="form-control" type="file" id="foto_tratamiento" name="foto_tratamiento" accept="image/*">
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="reset" class="btn btn-outline-secondary">Limpiar Formulario</button>
                        <button type="submit" class="btn btn-success">Guardar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Estilos adicionales -->
<style>
    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
    }
    .btn-success {
        background-color: #28a745;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
    }
    .btn-outline-secondary {
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
    }
</style>
@endsection