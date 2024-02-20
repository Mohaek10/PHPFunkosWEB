<?php
use PHPUnit\Framework\TestCase;
use models\Categoria;
use service\CategoriaService;
use PDO;
use PDOStatement;

class CategoriaServiceTest extends TestCase
{
    private $mockPDO;
    private $mockPDOStatement;
    private $categoriaService;

    public function setUp(): void
    {
        $this->mockPDO = $this->createMock(PDO::class);
        $this->mockPDOStatement = $this->createMock(PDOStatement::class);
        $this->categoriaService = new CategoriaService($this->mockPDO);
    }

    public function testFindAll()
    {
        $expectedCategorias = [
            new Categoria(1, 'Categoria 1', '2023-01-01', null, 0),
            new Categoria(2, 'Categoria 2', '2023-02-02', null, 0),
        ];

        $this->mockPDO
            ->expects($this->once())
            ->method('prepare')
            ->with('SELECT * FROM categorias ORDER BY id ASC')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement
            ->expects($this->exactly(3))
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC)
            ->will($this->onConsecutiveCalls(
                [
                    'id' => 1,
                    'nombre' => 'Categoria 1',
                    'created_at' => '2023-01-01',
                    'updated_at' => null,
                    'is_deleted' => 0,
                ],
                [
                    'id' => 2,
                    'nombre' => 'Categoria 2',
                    'created_at' => '2023-02-02',
                    'updated_at' => null,
                    'is_deleted' => 0,
                ]
            ));

        $categorias = $this->categoriaService->findAll();

        $this->assertEquals($expectedCategorias, $categorias);
    }
    public function testFindByNameExistingCategory()
    {
        $categoriaName = 'Categoria 1';
        $expectedCategoria = new Categoria(1, $categoriaName, '2023-01-01', null, 0);

        $this->mockPDO
            ->expects($this->once())
            ->method('prepare')
            ->with('SELECT * FROM categorias WHERE nombre = :nombre')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute')
            ->with(['nombre' => $categoriaName]);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn([
                'id' => 1,
                'nombre' => $categoriaName,
                'created_at' => '2023-01-01',
                'updated_at' => null,
                'is_deleted' => 0,
            ]);

        $categoria = $this->categoriaService->findByName($categoriaName);

        $this->assertEquals($expectedCategoria, $categoria);
    }

    public function testFindByNameNonExistingCategory()
    {
        $categoriaName = 'Non-existent Category';

        $this->mockPDO
            ->expects($this->once())
            ->method('prepare')
            ->with('SELECT * FROM categorias WHERE nombre = :nombre')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute')
            ->with(['nombre' => $categoriaName]);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn(false);

        $categoria = $this->categoriaService->findByName($categoriaName);

        $this->assertFalse($categoria);
    }







}
