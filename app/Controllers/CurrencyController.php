<?php

namespace App\Controllers;

use App\Repositories\CurrencyRepository;
use App\Requests\StoreCurrencyRequest;
use App\Requests\UpdateCurrencyRequest;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Controlador para gestionar monedas
 * Maneja las operaciones web (vistas) de monedas
 */
class CurrencyController extends BaseController
{
    /**
     * Instancia del repositorio de monedas
     *
     * @var CurrencyRepository
     */
    protected CurrencyRepository $repository;

    /**
     * Constructor
     * Inicializa el repositorio
     */
    public function __construct()
    {
        $this->repository = new CurrencyRepository();
    }

    /**
     * Listar todas las monedas paginadas
     *
     * @return string
     */
    public function index(): string
    {
        return view('currencies/index', [
            'title'      => 'Listado de Monedas',
            'pageTitle'  => 'Monedas',
            'breadcrumb' => ['Configuración' => null, 'Monedas' => null],
            'currencies' => $this->repository->getAllAlphabetical(),
            'stats'      => $this->repository->getStats(),
        ]);
    }

    /**
     * Mostrar formulario para crear nueva moneda (GET /currencies/new)
     *
     * @return string
     */
    public function new(): string
    {
        return view('currencies/create', [
            'title' => 'Crear Nueva Moneda',
        ]);
    }

    /**
     * Guardar nueva moneda (POST /currencies)
     *
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
    {
        try {
            StoreCurrencyRequest::validate($this->request);

            $data = StoreCurrencyRequest::validated($this->request);
            $this->repository->save($data);

            return redirect()->to('currencies')
                           ->with('success', 'Moneda creada exitosamente');
        } catch (\App\Exceptions\ValidationException $e) {
            return redirect()->back()
                           ->with('errors', $e->getErrors())
                           ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Mostrar detalles de una moneda
     *
     * @param int $id ID de la moneda
     * @return string
     * @throws ResourceNotFoundException
     */
    public function show(int $id): string
    {
        $currency = $this->repository->getById($id);

        if (!$currency) {
            throw new ResourceNotFoundException('Moneda no encontrada');
        }

        return view('currencies/show', [
            'title'    => 'Detalles de la Moneda',
            'currency' => $currency,
        ]);
    }

    /**
     * Mostrar formulario para editar una moneda
     *
     * @param int $id ID de la moneda
     * @return string
     * @throws ResourceNotFoundException
     */
    public function edit(int $id): string
    {
        $currency = $this->repository->getById($id);

        if (!$currency) {
            throw new ResourceNotFoundException('Moneda no encontrada');
        }

        return view('currencies/edit', [
            'title'    => 'Editar Moneda',
            'currency' => $currency,
        ]);
    }

    /**
     * Actualizar una moneda
     *
     * @param int $id ID de la moneda
     * @return RedirectResponse
     * @throws ResourceNotFoundException
     */
    public function update(int $id): RedirectResponse
    {
        try {
            $currency = $this->repository->getById($id);

            if (!$currency) {
                throw new ResourceNotFoundException('Moneda no encontrada');
            }

            UpdateCurrencyRequest::validate($this->request, $id);
            $data = UpdateCurrencyRequest::validated($this->request, $id);
            $this->repository->update($id, $data);

            return redirect()->to('currencies')
                           ->with('success', 'Moneda actualizada exitosamente');
        } catch (\App\Exceptions\ValidationException $e) {
            return redirect()->back()
                           ->with('errors', $e->getErrors())
                           ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', $e->getMessage())
                           ->withInput();
        }
    }


    /**
     * Eliminar una moneda
     *
     * @param int $id ID de la moneda
     * @return RedirectResponse
     * @throws ResourceNotFoundException
     */
    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Moneda no encontrada');
            }

            $this->repository->delete($id);

            return redirect()->to('currencies')
                           ->with('success', 'Moneda eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', $e->getMessage());
        }
    }
}