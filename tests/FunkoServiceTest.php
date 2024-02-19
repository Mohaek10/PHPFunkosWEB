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
        $funkos = [$funko, $funko1];

        $this->mockPDO
            ->expects($this->once())
            ->method('prepare')
            ->with('SELECT f.*, c.nombre as categoria_nombre FROM funko f left join categorias c on f.categoria_id = c.id' . ($searchTerm ? ' WHERE lower(f.nombre) like :searchTerm' : '') . ' ORDER BY f.id ASC')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':searchTerm', '%nombre%', PDO::PARAM_STR)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute');


        $this->mockPDOStatement
            ->expects($this->exactly(2))
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC | PDO::FETCH_PROPS_LATE, Funkos::class)
            ->will($this->onConsecutiveCalls($funko, $funko1));
        $this->assertEquals($funkos, $this->funkoService->findAllWithCategoryName('nombre'));


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
            ->with('SELECT f.*, c.nombre as categoria_nombre FROM funko f left join categorias c on f.categoria_id = c.id WHERE f.id = :id')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':id', 1, PDO::PARAM_INT)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC | PDO::FETCH_PROPS_LATE, Funkos::class)
            ->willReturn($funko);

        $this->assertEquals($funko, $this->funkoService->findById(1));
    }

    public function testfindByIdNotFound()
    {
        $id = 1;

        $this->mockPDO
            ->expects($this->once())
            ->method('prepare')
            ->with('SELECT f.*, c.nombre as categoria_nombre FROM funko f left join categorias c on f.categoria_id = c.id WHERE f.id = :id')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':id', 1, PDO::PARAM_INT)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC | PDO::FETCH_PROPS_LATE, Funkos::class)
            ->willReturn(false);

        $this->assertEquals(null, $this->funkoService->findById(1));
    }

    public function testCreate()
    {
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
            ->with('INSERT INTO funko (nombre, precio, cantidad, imagen, createdat, updatedat, categoria_id) VALUES ( :nombre, :precio, :cantidad, :imagen, :createdat, :updatedat, :categoria_id)')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':nombre', 'nombre', PDO::PARAM_STR)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':precio', 100, PDO::PARAM_STR)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':cantidad', 10, PDO::PARAM_STR)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':imagen', 'imagen', PDO::PARAM_STR)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':createdat', '2021-01-01', PDO::PARAM_STR)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':updatedat', '2021-01-01', PDO::PARAM_STR)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':categoria_id', 1, PDO::PARAM_INT)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute');

        $this->funkoService->create($funko);
        $this->assertEquals($funko, $this->funkoService->create($funko));
    }

    public function testUpdate()
    {
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
            ->with('UPDATE funko SET 
                  nombre = :nombre, 
                  precio = :precio, 
                  cantidad = :cantidad, 
                  imagen = :imagen, 
                  updatedat = :updatedat, 
                  categoria_id = :categoria_id 
              WHERE id = :id')
            ->willReturn($this->mockPDOStatement);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':nombre', 'nombre', PDO::PARAM_STR)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':precio', 100, PDO::PARAM_STR)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':cantidad', 10, PDO::PARAM_STR)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':imagen', 'imagen', PDO::PARAM_STR)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':updatedat', '2021-01-01', PDO::PARAM_STR)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':categoria_id', 1, PDO::PARAM_INT)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('bindValue')
            ->with(':id', 1, PDO::PARAM_INT)
            ->willReturn(true);

        $this->mockPDOStatement
            ->expects($this->once())
            ->method('execute');

        $this->funkoService->update($funko);
        $this->assertEquals($funko, $this->funkoService->update($funko));
    }


}
