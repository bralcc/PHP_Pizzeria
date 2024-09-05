<?php
use PHPUnit\Framework\TestCase;
use Data\AddressDAO;
use Entities\Address;
use Exceptions\DatabaseErrorException;

class AddressDAOTest extends TestCase
{
    private $pdo;
    private $pdoStatement;
    private $addressDAO;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->pdoStatement = $this->createMock(PDOStatement::class);
        $this->addressDAO = new AddressDAO($this->pdo); // Assuming AddressDAO is modified to accept a PDO instance
    }

    public function testGetAllSuccess()
    {
        $expectedAddresses = [
            ['zipcode' => '12345', 'name' => 'Test City', 'delivery_availability' => true],
            ['zipcode' => '67890', 'name' => 'Another City', 'delivery_availability' => false]
        ];

        $this->pdo->method('prepare')->willReturn($this->pdoStatement);
        $this->pdoStatement->method('execute')->willReturn(true);
        $this->pdoStatement->method('fetchAll')->willReturn($expectedAddresses);

        $addresses = $this->addressDAO->getAll();

        $this->assertIsArray($addresses);
        $this->assertCount(2, $addresses);
        $this->assertInstanceOf(Address::class, $addresses[0]);
        $this->assertEquals('Test City', $addresses[0]->getCity());
    }

    public function testGetAllDatabaseError()
    {
        $this->pdo->method('prepare')->will($this->throwException(new PDOException()));

        $this->expectException(DatabaseErrorException::class);
        $this->expectExceptionMessage('Error fetching addresses:');

        $this->addressDAO->getAll();
    }
}
