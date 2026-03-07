<?php

use App\Responses\ApiResponse;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class ApiResponseTest extends CIUnitTestCase
{
    // -----------------------------------------------------------------------
    // success()
    // -----------------------------------------------------------------------

    public function testSuccessReturnsCorrectStructure(): void
    {
        $result = ApiResponse::success();

        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('message', $result);
        $this->assertArrayHasKey('data', $result);
    }

    public function testSuccessDefaultValues(): void
    {
        $result = ApiResponse::success();

        $this->assertTrue($result['success']);
        $this->assertSame(200, $result['status']);
        $this->assertSame('Éxito', $result['message']);
        $this->assertNull($result['data']);
    }

    public function testSuccessWithData(): void
    {
        $data   = ['id' => 1, 'name' => 'Servicio A'];
        $result = ApiResponse::success($data);

        $this->assertTrue($result['success']);
        $this->assertSame(200, $result['status']);
        $this->assertSame($data, $result['data']);
    }

    public function testSuccessWithCustomCodeAndMessage(): void
    {
        $result = ApiResponse::success(['id' => 5], 201, 'Creado correctamente');

        $this->assertSame(201, $result['status']);
        $this->assertSame('Creado correctamente', $result['message']);
        $this->assertTrue($result['success']);
    }

    public function testSuccessWithEmptyArray(): void
    {
        $result = ApiResponse::success([]);

        $this->assertTrue($result['success']);
        $this->assertIsArray($result['data']);
        $this->assertEmpty($result['data']);
    }

    public function testSuccessWithScalarData(): void
    {
        $result = ApiResponse::success(42);

        $this->assertSame(42, $result['data']);
    }

    // -----------------------------------------------------------------------
    // error()
    // -----------------------------------------------------------------------

    public function testErrorReturnsCorrectStructure(): void
    {
        $result = ApiResponse::error();

        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('message', $result);
        $this->assertArrayNotHasKey('errors', $result);
    }

    public function testErrorDefaultValues(): void
    {
        $result = ApiResponse::error();

        $this->assertFalse($result['success']);
        $this->assertSame(400, $result['status']);
        $this->assertSame('Error', $result['message']);
    }

    public function testErrorWithCustomMessageAndCode(): void
    {
        $result = ApiResponse::error('Algo salió mal', 500);

        $this->assertFalse($result['success']);
        $this->assertSame(500, $result['status']);
        $this->assertSame('Algo salió mal', $result['message']);
    }

    public function testErrorWithErrorsIncludesErrorsKey(): void
    {
        $errors = ['campo' => 'requerido'];
        $result = ApiResponse::error('Error de validación', 422, $errors);

        $this->assertArrayHasKey('errors', $result);
        $this->assertSame($errors, $result['errors']);
    }

    public function testErrorWithNullErrorsDoesNotIncludeErrorsKey(): void
    {
        $result = ApiResponse::error('Error', 400, null);

        $this->assertArrayNotHasKey('errors', $result);
    }

    public function testErrorWithZeroAsErrorsIncludesErrorsKey(): void
    {
        $result = ApiResponse::error('Error', 400, 0);

        $this->assertArrayHasKey('errors', $result);
        $this->assertSame(0, $result['errors']);
    }

    // -----------------------------------------------------------------------
    // validationFailed()
    // -----------------------------------------------------------------------

    public function testValidationFailedReturnsCorrectStructure(): void
    {
        $result = ApiResponse::validationFailed(['name' => 'El nombre es requerido']);

        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('message', $result);
        $this->assertArrayHasKey('errors', $result);
    }

    public function testValidationFailedValues(): void
    {
        $errors = ['email' => 'Email inválido', 'name' => 'Requerido'];
        $result = ApiResponse::validationFailed($errors);

        $this->assertFalse($result['success']);
        $this->assertSame(422, $result['status']);
        $this->assertSame('Validation failed', $result['message']);
        $this->assertSame($errors, $result['errors']);
    }

    public function testValidationFailedWithCustomMessage(): void
    {
        $result = ApiResponse::validationFailed([], 'Error de validación personalizado');

        $this->assertSame('Error de validación personalizado', $result['message']);
        $this->assertSame(422, $result['status']);
    }

    public function testValidationFailedWithEmptyErrors(): void
    {
        $result = ApiResponse::validationFailed([]);

        $this->assertFalse($result['success']);
        $this->assertIsArray($result['errors']);
        $this->assertEmpty($result['errors']);
    }

    public function testValidationFailedWithMultipleFieldErrors(): void
    {
        $errors = [
            'name'     => 'El nombre es requerido',
            'email'    => 'Formato de email inválido',
            'password' => 'Mínimo 8 caracteres',
        ];
        $result = ApiResponse::validationFailed($errors);

        $this->assertCount(3, $result['errors']);
        $this->assertSame('El nombre es requerido', $result['errors']['name']);
    }

    // -----------------------------------------------------------------------
    // notFound()
    // -----------------------------------------------------------------------

    public function testNotFoundDefaultMessage(): void
    {
        $result = ApiResponse::notFound();

        $this->assertFalse($result['success']);
        $this->assertSame(404, $result['status']);
        $this->assertSame('Recurso no encontrado', $result['message']);
    }

    public function testNotFoundWithCustomMessage(): void
    {
        $result = ApiResponse::notFound('Servicio no encontrado');

        $this->assertSame(404, $result['status']);
        $this->assertSame('Servicio no encontrado', $result['message']);
        $this->assertFalse($result['success']);
    }

    public function testNotFoundDoesNotContainErrorsKey(): void
    {
        $result = ApiResponse::notFound();

        $this->assertArrayNotHasKey('errors', $result);
    }

    // -----------------------------------------------------------------------
    // unauthorized()
    // -----------------------------------------------------------------------

    public function testUnauthorizedDefaultMessage(): void
    {
        $result = ApiResponse::unauthorized();

        $this->assertFalse($result['success']);
        $this->assertSame(401, $result['status']);
        $this->assertSame('No autorizado', $result['message']);
    }

    public function testUnauthorizedWithCustomMessage(): void
    {
        $result = ApiResponse::unauthorized('Token expirado');

        $this->assertSame(401, $result['status']);
        $this->assertSame('Token expirado', $result['message']);
        $this->assertFalse($result['success']);
    }

    public function testUnauthorizedDoesNotContainErrorsKey(): void
    {
        $result = ApiResponse::unauthorized();

        $this->assertArrayNotHasKey('errors', $result);
    }

    // -----------------------------------------------------------------------
    // paginated()
    // -----------------------------------------------------------------------

    public function testPaginatedReturnsCorrectStructure(): void
    {
        $pager  = $this->makePager(total: 50, perPage: 10, current: 1, lastPage: 5);
        $result = ApiResponse::paginated([], $pager);

        $this->assertTrue($result['success']);
        $this->assertSame(200, $result['status']);
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('items', $result['data']);
        $this->assertArrayHasKey('total', $result['data']);
        $this->assertArrayHasKey('perPage', $result['data']);
        $this->assertArrayHasKey('currentPage', $result['data']);
        $this->assertArrayHasKey('lastPage', $result['data']);
        $this->assertArrayHasKey('hasNext', $result['data']);
        $this->assertArrayHasKey('hasPrevious', $result['data']);
    }

    public function testPaginatedValues(): void
    {
        $items  = [['id' => 1], ['id' => 2]];
        $pager  = $this->makePager(total: 50, perPage: 10, current: 2, lastPage: 5, hasNext: true, hasPrevious: true);
        $result = ApiResponse::paginated($items, $pager);

        $data = $result['data'];
        $this->assertSame($items, $data['items']);
        $this->assertSame(50, $data['total']);
        $this->assertSame(10, $data['perPage']);
        $this->assertSame(2, $data['currentPage']);
        $this->assertSame(5, $data['lastPage']);
        $this->assertTrue($data['hasNext']);
        $this->assertTrue($data['hasPrevious']);
    }

    public function testPaginatedFirstPageHasNoPrevious(): void
    {
        $pager  = $this->makePager(total: 30, perPage: 10, current: 1, lastPage: 3, hasNext: true, hasPrevious: false);
        $result = ApiResponse::paginated([], $pager);

        $this->assertTrue($result['data']['hasNext']);
        $this->assertFalse($result['data']['hasPrevious']);
    }

    public function testPaginatedLastPageHasNoNext(): void
    {
        $pager  = $this->makePager(total: 30, perPage: 10, current: 3, lastPage: 3, hasNext: false, hasPrevious: true);
        $result = ApiResponse::paginated([], $pager);

        $this->assertFalse($result['data']['hasNext']);
        $this->assertTrue($result['data']['hasPrevious']);
    }

    public function testPaginatedSinglePageHasNoNextOrPrevious(): void
    {
        $pager  = $this->makePager(total: 5, perPage: 10, current: 1, lastPage: 1, hasNext: false, hasPrevious: false);
        $result = ApiResponse::paginated([], $pager);

        $this->assertFalse($result['data']['hasNext']);
        $this->assertFalse($result['data']['hasPrevious']);
    }

    public function testPaginatedMessageIsCorrect(): void
    {
        $pager  = $this->makePager();
        $result = ApiResponse::paginated([], $pager);

        $this->assertSame('Listado obtenido correctamente', $result['message']);
    }

    // -----------------------------------------------------------------------
    // Helper
    // -----------------------------------------------------------------------

    private function makePager(
        int $total = 0,
        int $perPage = 10,
        int $current = 1,
        int $lastPage = 1,
        bool $hasNext = false,
        bool $hasPrevious = false,
    ): object {
        $pager = $this->createMock(stdClass::class);

        $pager = new class ($total, $perPage, $current, $lastPage, $hasNext, $hasPrevious) {
            public function __construct(
                private int $total,
                private int $perPage,
                private int $current,
                private int $lastPage,
                private bool $hasNext,
                private bool $hasPrevious,
            ) {}

            public function getTotal(): int       { return $this->total; }
            public function getPerPage(): int      { return $this->perPage; }
            public function getCurrentPage(): int  { return $this->current; }
            public function getPageCount(): int    { return $this->lastPage; }
            public function hasNext(): bool        { return $this->hasNext; }
            public function hasPrevious(): bool    { return $this->hasPrevious; }
        };

        return $pager;
    }
}
