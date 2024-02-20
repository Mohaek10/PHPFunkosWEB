<?php

use PHPUnit\Framework\TestCase;
use models\Funkos;
use service\FunkoService;
use PDO;
use PDOStatement;

class FunkoServiceTest extends TestCase
{
    private $mockPDO;
    private $mockPDOStatement;
    private $funkoService;

    public function setUp(): void
    {
        $this->mockPDO = $this->createMock(PDO::class);
        $this->mockPDOStatement = $this->createMock(PDOStatement::class);
        $this->funkoService = new FunkoService($this->mockPDO);
    }

    public function testfindAllWithCategoryName()
    {
        $searchTerm = 'nombre';
        $funko = new Funkos(
            1,
            'nombre',
            100,
            10,
            'imagen',
            '2021-01-01',
            '2021-01-01',
            1,
            'categoria_nombre',
            false
        );
        $funko1 = new Funkos(
            2,
            'nombre1',
            200,
            20,
            'imagen1',
            '2021-01-01',
            '2021-01-01',
            2,
            'categoria_nombre1',
            true
        );
        $expectedResult = [$funko, $funko1];

        $this->mockPDO
            ->expects($this->once())
            ->method('prepare')
            ->with('SELECT f.*, c.nombre as categoria_nombre FROM funko f LEFT JOIN categorias c ON f.categoria_id = c.id' . ($searchTerm ? ' WHERE LOWER(f.nombre) LIKE :searchTerm' : '') . ' ORDER BY f.id ASC')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':searchTerm', '%nombre%', PDO::PARAM_STR);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement
            ->expects($this->exactly(3))
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC)
            ->will($this->onConsecutiveCalls(
                ['id' => 1, 'nombre' => 'nombre', 'precio' => 100, 'cantidad' => 10, 'imagen' => 'imagen', 'createdat' => '2021-01-01', 'updatedat' => '2021-01-01', 'categoria_id' => 1, 'categoria_nombre' => 'categoria_nombre', 'is_deleted' => false],
                ['id' => 2, 'nombre' => 'nombre1', 'precio' => 200, 'cantidad' => 20, 'imagen' => 'imagen1', 'createdat' => '2021-01-01', 'updatedat' => '2021-01-01', 'categoria_id' => 2, 'categoria_nombre' => 'categoria_nombre1', 'is_deleted' => true]
            ));

        $result = $this->funkoService->findAllWithCategoryName('nombre');


        $this->assertEquals($expectedResult, $result);
    }
    public function testfindById()
    {
        $id = 1;
        $funko = new Funkos(
            1,
            'nombre',
            100,
            10,
            'imagen',
            '2021-01-01',
            '2021-01-01',
            1,
            'categoria_nombre',
            false
        );

        $this->mockPDO
            ->expects($this->once())
            ->method('prepare')
            ->with('SELECT f.*, c.nombre as categoria_nombre FROM funko f LEFT JOIN categorias c ON f.categoria_id = c.id WHERE f.id = :id')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':id', 1, PDO::PARAM_INT);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn(['id' => 1, 'nombre' => 'nombre', 'precio' => 100, 'cantidad' => 10, 'imagen' => 'imagen', 'createdat' => '2021-01-01', 'updatedat' => '2021-01-01', 'categoria_id' => 1, 'categoria_nombre' => 'categoria_nombre', 'is_deleted' => false]);

        $result = $this->funkoService->findById(1);

        $this->assertEquals($funko, $result);
    }

    public function testcreate()
    {
        $currentDate = date('Y-m-d H:i:s');

        $funko = new Funkos(
            1,
            'nombre',
            100,
            10,
            'imagen',
            $currentDate,
            $currentDate,
            1,
            'categoria_nombre',
            false
        );

        $this->mockPDO
            ->expects($this->once())
            ->method('prepare')
            ->with('INSERT INTO funko (nombre, precio, cantidad, imagen, createdat, updatedat, categoria_id) VALUES ( :nombre, :precio, :cantidad, :imagen, :createdat, :updatedat, :categoria_id)')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->exactly(7))
            ->method('bindValue')
            ->withConsecutive(
                [':nombre', 'nombre', PDO::PARAM_STR],
                [':precio', 100, PDO::PARAM_STR],
                [':cantidad', 10, PDO::PARAM_INT],
                [':imagen', 'imagen', PDO::PARAM_STR],
                [':createdat',$currentDate, PDO::PARAM_STR],
                [':updatedat', $currentDate, PDO::PARAM_STR],
                [':categoria_id', 1, PDO::PARAM_INT]
            );

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute');

        $result = $this->funkoService->create($funko);

        $this->assertEquals(null, $result);
    }

    public function testupdate()
    {
        $currentDate = date('Y-m-d H:i:s');

        $funko = new Funkos(
            1,
            'nombre',
            100,
            10,
            'imagen',
            $currentDate,
            $currentDate,
            1,
            'categoria_nombre',
            false
        );

        $this->mockPDO
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->exactly(7))
            ->method('bindValue')
            ->withConsecutive(
                [':nombre', 'nombre', PDO::PARAM_STR],
                [':precio', 100, PDO::PARAM_STR],
                [':cantidad', 10, PDO::PARAM_INT],
                [':imagen', 'imagen', PDO::PARAM_STR],
                [':updatedat', $currentDate, PDO::PARAM_STR],
                [':categoria_id', 1, PDO::PARAM_INT],
                [':id', 1, PDO::PARAM_INT]
            );

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute');

        $result = $this->funkoService->update($funko);

        $this->assertEquals(null, $result);
    }
    public function testdelete()
    {
        $id = 1;

        $this->mockPDO
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':id', 1, PDO::PARAM_INT);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute');

        $result = $this->funkoService->delete(1);

        $this->assertEquals(null, $result);
    }



}
