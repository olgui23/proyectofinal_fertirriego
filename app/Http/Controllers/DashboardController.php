<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cultivo;
use App\Models\Sensor;
use App\Models\LoginActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
     public function index()
    {       
        return view('dashboard'); 
    }

    public function adminDashboard(){
        return view('dashboard_admin', $data=$this->dashboard());
    }

    public function farmDashboard()
    {
        return view('dashboard_farm');
    }

    public function buyerDashboard()
    {
        return view('dashboard_buyer');
    }


    public function dashboard()
    {
        try {
            $stats = [
            'totalUsers' => User::count(),
            'adminCount' => $this->safeCount(User::class, 'rol', 'administrador', 0),
            'farmersCount' => $this->safeCount(User::class, 'rol', 'agricultor', 0),
            'buyersCount' => $this->safeCount(User::class, 'rol', 'comprador', 0),
            'activeCrops' => $this->safeCount(Cultivo::class, 'estado', 'activo', 0),
            'recentUsers' => User::orderBy('created_at', 'desc')->limit(5)->get()
            ];

            return $stats;

        } catch (Exception $e) {
            // Log del error y retornar valores por defecto
            logger()->error('Error en dashboard: ' . $e->getMessage());
            
            // Manejo de errores
            return [
                'totalUsers' => 0,
                'adminCount' => 0,
                'farmersCount' => 0,
                'buyersCount' => 0,
                'activeCrops' => 0,
                'recentUsers' => collect()
            ];
        }
    }

    public function dashboardStats()
    {
        try {
            return response()->json([
                'admin_count' => $this->safeCount(User::class, 'rol', 'administrador', 0),
                'farmers_count' => $this->safeCount(User::class, 'rol', 'agricultor', 0),
                'buyers_count' => $this->safeCount(User::class, 'rol', 'comprador', 0),
                'active_crops' => $this->safeCount(Cultivo::class, 'estado', 'activo', 0)
            ]);
        } catch (Exception $e) {
            logger()->error('Error en dashboardStats: ' . $e->getMessage());
            
            return response()->json([
                'admin_count' => 0,
                'farmers_count' => 0,
                'buyers_count' => 0,
                'active_crops' => 0
            ]);
        }
    }

    /**
     * Método seguro para contar registros con manejo de errores
     */
    protected function safeCount($model, $field, $value, $default = 0)
    {
        try {
            return $model::where($field, $value)->count();
        } catch (Exception $e) {
            // Si falla, intentar con campo alternativo 'rol'
            if ($field === 'rol') {
                try {
                    return $model::where('rol', $value)->count();
                } catch (Exception $e) {
                    logger()->warning("Campo 'rol' no encontrado en " . get_class($model));
                    return $default;
                }
            }
            
            logger()->warning("Campo '{$field}' no encontrado en " . get_class($model));
            return $default;
        }
    }

    protected function getSystemAlerts()
    {
        $alerts = [];

        try {
            // Verificar usuarios inactivos (si el campo existe)
            $inactiveUsers = User::where('estado', 'inactivo')->count();
            if ($inactiveUsers > 0) {
                $alerts[] = "Hay {$inactiveUsers} usuario(s) inactivo(s) que requieren atención.";
            }
        } catch (Exception $e) {
            // Campo 'estado' probablemente no existe en users
        }

        try {
            // Verificar equipos con mantenimiento pendiente
            $maintenanceDue = Sensor::where('activo', 'false')
                ->count();
                
            if ($maintenanceDue > 0) {
                $alerts[] = "Hay {$maintenanceDue} equipo(s) que requieren mantenimiento pronto.";
            }
        } catch (Exception $e) {
            // Campos probablemente no existen en sensors
        }

        try {
            // Verificar cultivos con problemas
            $problemCrops = Cultivo::where('estado', 'problema')->count();
            if ($problemCrops > 0) {
                $alerts[] = "Hay {$problemCrops} cultivo(s) reportados con problemas.";
            }
        } catch (Exception $e) {
            // Campo 'estado' probablemente no existe en cultivos
        }

        return $alerts;
    }
}