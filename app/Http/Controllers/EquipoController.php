<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EquipoController extends Controller
{
    // Mostrar todos los equipos
    public function index()
    {
        $equipos = Equipo::with('user')->paginate(10);
        return view('equipos.equipos', compact('equipos'));
    }

    // Formulario para crear nuevo equipo
    public function create()
    {
        // Solo usuarios con rol 'agricultor'
        $users = User::where('rol', 'agricultor')->get();

        return view('equipos.create', compact('users'));
    }

    // Guardar nuevo equipo
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'mac' => 'required|unique:equipos,mac',
            'fecha_instalacion' => 'required|date|before_or_equal:today',
        ]);

        Equipo::create($request->all());

        return redirect()->route('equipos.index')->with('success', 'Equipo registrado correctamente');
    }

    // Mostrar un equipo
    // EquipoController.php

public function show($id)
{
    $equipo = Equipo::with('user')->findOrFail($id);

    if (request()->wantsJson() || request()->ajax()) {
        return response()->json($equipo);
    }

    return view('equipos.show', compact('equipo'));
}



    // Formulario editar
    public function edit($id)
    {
        $equipo = Equipo::findOrFail($id);

        // Solo usuarios con rol 'agricultor'
        $users = User::where('rol', 'agricultor')->get();

        return view('equipos.edit', compact('equipo', 'users'));
    }

    // Actualizar equipo
    public function update(Request $request, $id)
    {
        $equipo = Equipo::findOrFail($id);

        $request->validate([
            'mac' => 'required|unique:equipos,mac,' . $equipo->id,
            'fecha_instalacion' => 'required|date|before_or_equal:today',
        ]);

        $equipo->update($request->all());

        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado');
    }

    // Eliminar equipo
    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();

        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado');
    }

    // Vista con PDF embebido
    public function viewPdf()
    {
        $equipos = Equipo::with('user')->get();

        $pdf = Pdf::loadView('equipos.equipos_pdf', compact('equipos'));

        $pdfContent = base64_encode($pdf->output());

        return view('equipos.equipos_pdf_view', compact('pdfContent'));
    }

    // Descarga directa del PDF
    public function downloadPdf()
    {
        $equipos = Equipo::with('user')->get();

        $pdf = Pdf::loadView('equipos.equipos_pdf', compact('equipos'));

        return $pdf->download('equipos.pdf');
    }
}
